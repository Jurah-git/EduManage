<?php
namespace App\Http\Controllers;

use App\Models\AnnulationPaiement;
use App\Models\DetailPaiement;
use App\Models\Eleve;
use App\Models\EleveFrais;
use App\Models\Paiement;
use App\Models\Recu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    /**
     * Vérifier une permission.
     */
    private function verifierPermission(string $permission): void
    {
        $user = auth()->user();

        abort_unless(
            $user && $user->aPermission($permission),
            403,
            'Vous n’avez pas la permission d’effectuer cette opération.'
        );
    }

    /**
     * Calculer le montant déjà payé sur un frais.
     * Seuls les paiements validés sont pris en compte.
     */
    private function montantDejaPaye(EleveFrais $frais): float
    {
        return (float) $frais->detailsPaiements()
            ->whereHas('paiement', function ($query) {
                $query->where('statut', 'valide');
            })
            ->sum('montant_paye');
    }

    /**
     * Déterminer le statut réel d'un frais.
     */
    private function determinerStatut(
        float $montantDu,
        float $montantPaye
    ): string {
        $reste = round($montantDu - $montantPaye, 2);

        if ($reste <= 0.009) {
            return 'paye';
        }

        return $montantPaye > 0 ? 'partiel' : 'impaye';
    }

    /**
     * Liste des paiements.
     */
    public function index(Request $request)
    {
        $this->verifierPermission('frais.paiements_voir');

        $query = Paiement::with([
            'eleve.classe',
            'utilisateur',
            'recu',
            'annulation',
        ])->latest('date_paiement');

        if ($request->filled('recherche')) {
            $recherche = trim($request->recherche);

            $query->where(function ($q) use ($recherche) {
                $q->where('numero_paiement', 'like', "%{$recherche}%")
                    ->orWhereHas('eleve', function ($eleveQuery) use ($recherche) {
                        $eleveQuery->where('nom', 'like', "%{$recherche}%")
                            ->orWhere('prenom', 'like', "%{$recherche}%")
                            ->orWhere('matricule', 'like', "%{$recherche}%");
                    });
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $paiements = $query->paginate(15)->withQueryString();

        return view('frais.paiements.index', compact('paiements'));
    }

    /**
     * Formulaire d'encaissement.
     */
    public function create(Request $request)
    {
        $this->verifierPermission('frais.encaisser');

        $eleves = Eleve::with('classe')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        $eleveSelectionne = null;
        $frais            = collect();

        if ($request->filled('eleve_id')) {
            $request->validate([
                'eleve_id' => 'required|integer|exists:eleves,id',
            ]);

            $eleveSelectionne = Eleve::with('classe')
                ->findOrFail($request->eleve_id);

            $frais = EleveFrais::with([
                'tarifFrais.typeFrais',
            ])
                ->where('eleve_id', $eleveSelectionne->id)
                ->orderBy('date_echeance')
                ->get();

            foreach ($frais as $ligne) {
                $paye = $this->montantDejaPaye($ligne);

                $ligne->setAttribute('montant_paye', $paye);
                $ligne->setAttribute(
                    'reste_a_payer',
                    max(0, round((float) $ligne->montant_du - $paye, 2))
                );
            }

            $frais = $frais->filter(function ($ligne) {
                return $ligne->reste_a_payer > 0;
            })->values();
        }

        return view('frais.paiements.create', compact(
            'eleves',
            'eleveSelectionne',
            'frais'
        ));
    }

    /**
     * Enregistrer un paiement et générer son reçu.
     */
    public function store(Request $request)
    {
        $this->verifierPermission('frais.encaisser');

        $donnees = $request->validate([
            'eleve_id'      => [
                'required',
                'integer',
                'exists:eleves,id',
            ],
            'date_paiement' => [
                'required',
                'date',
            ],
            'observations'  => [
                'nullable',
                'string',
                'max:2000',
            ],
            'frais'         => [
                'required',
                'array',
                'min:1',
            ],
            'frais.*'       => [
                'nullable',
                'numeric',
                'min:0.01',
            ],
        ], [
            'eleve_id.required'      => 'Veuillez sélectionner un élève.',
            'date_paiement.required' => 'La date du paiement est obligatoire.',
            'frais.required'         => 'Veuillez sélectionner au moins un frais.',
            'frais.min'              => 'Veuillez saisir au moins un montant à payer.',
            'frais.*.numeric'        => 'Chaque montant doit être numérique.',
            'frais.*.min'            => 'Chaque montant doit être supérieur à zéro.',
        ]);

        // Ne conserver que les montants strictement positifs.
        $montants = collect($donnees['frais'])
            ->filter(function ($montant) {
                return $montant !== null && (float) $montant > 0;
            });

        if ($montants->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors([
                    'frais' => 'Veuillez saisir au moins un montant à encaisser.',
                ]);
        }

        $resultat = DB::transaction(function () use (
            $donnees,
            $montants
        ) {
            // Verrouiller les frais concernés pour éviter les doubles encaissements.
            $lignes = EleveFrais::where('eleve_id', $donnees['eleve_id'])
                ->whereIn('id', $montants->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($lignes->count() !== $montants->count()) {
                abort(422, 'Un ou plusieurs frais sélectionnés sont invalides.');
            }

/*
 * Vérifier si ce même encaissement a déjà été enregistré.
 * Cela évite les doubles paiements en cas de double clic
 * ou de soumission répétée du formulaire.
 */
            $paiementsExistants = Paiement::where('eleve_id', $donnees['eleve_id'])
                ->where('statut', 'valide')
                ->whereHas('details', function ($query) use ($montants) {
                    $query->whereIn('eleve_frais_id', $montants->keys());
                })
                ->with('details')
                ->lockForUpdate()
                ->get();

            foreach ($paiementsExistants as $paiementExistant) {

                $detailsExistants = $paiementExistant->details->keyBy('eleve_frais_id');

                if ($detailsExistants->count() !== $montants->count()) {
                    continue;
                }

                $memeEncaissement = true;

                foreach ($montants as $fraisId => $montant) {

                    $detailExistant = $detailsExistants->get($fraisId);

                    if (
                        ! $detailExistant ||
                        round((float) $detailExistant->montant_paye, 2)
                        !== round((float) $montant, 2)
                    ) {
                        $memeEncaissement = false;
                        break;
                    }
                }

                if ($memeEncaissement) {
                    return [
                        'paiement'        => $paiementExistant,
                        'deja_enregistre' => true,
                    ];
                }
            }

            $montantTotal = 0;

            // Vérifier chaque montant avant de créer le paiement.
            foreach ($montants as $fraisId => $montant) {
                $ligne = $lignes->get($fraisId);

                $montantDu      = (float) $ligne->montant_du;
                $montantPaye    = $this->montantDejaPaye($ligne);
                $reste          = round($montantDu - $montantPaye, 2);
                $montantDemande = round((float) $montant, 2);

                if ($reste <= 0.009) {
                    abort(422, 'Un frais sélectionné est déjà entièrement payé.');
                }

                if ($montantDemande > $reste + 0.001) {
                    abort(
                        422,
                        'Le montant saisi dépasse le reste à payer pour le frais : '
                        . $ligne->libelle
                    );
                }

                $montantTotal += $montantDemande;
            }

            $montantTotal = round($montantTotal, 2);

            if ($montantTotal <= 0) {
                abort(422, 'Le montant total du paiement doit être supérieur à zéro.');
            }

            // Générer un numéro de paiement unique.
            $numeroPaiement = 'PAY-'
            . now()->format('Ymd-His')
            . '-'
            . Str::upper(Str::random(6));

            // Créer le paiement principal.
            $paiement = Paiement::create([
                'numero_paiement' => $numeroPaiement,
                'eleve_id'        => $donnees['eleve_id'],
                'user_id'         => auth()->id(),
                'date_paiement'   => Carbon::parse(
                    $donnees['date_paiement']
                ),
                'montant_total'   => $montantTotal,
                'mode_paiement'   => 'especes',
                'statut'          => 'valide',
                'observations'    => $donnees['observations'] ?? null,
            ]);

            // Enregistrer les détails et actualiser les statuts des frais.
            foreach ($montants as $fraisId => $montant) {
                $ligne       = $lignes->get($fraisId);
                $montantPaye = round((float) $montant, 2);

                DetailPaiement::create([
                    'paiement_id'    => $paiement->id,
                    'eleve_frais_id' => $ligne->id,
                    'montant_paye'   => $montantPaye,
                ]);

                $nouveauTotalPaye = $this->montantDejaPaye($ligne);

                $ligne->update([
                    'statut' => $this->determinerStatut(
                        (float) $ligne->montant_du,
                        $nouveauTotalPaye
                    ),
                ]);
            }

            // Générer automatiquement le reçu.
            $numeroRecu = 'REC-'
            . now()->format('Ymd-His')
            . '-'
            . Str::upper(Str::random(6));

            Recu::create([
                'paiement_id'   => $paiement->id,
                'numero_recu'   => $numeroRecu,
                'date_emission' => now(),
                'observations'  => null,
            ]);

            return [
                'paiement'        => $paiement,
                'deja_enregistre' => false,
            ];
        });

        $paiement = $resultat['paiement'];

        $message = $resultat['deja_enregistre']
            ? 'Cet encaissement avait déjà été enregistré. Le paiement existant est affiché.'
            : 'Paiement enregistré et reçu généré avec succès.';

        return redirect()
            ->route('frais.paiements.show', $paiement)
            ->with('success', $message);
    }

    /**
     * Afficher les détails d'un paiement.
     */
    public function show(Paiement $paiement)
    {
        $this->verifierPermission('frais.paiements_voir');

        $paiement->load([
            'eleve.classe',
            'utilisateur',
            'details.eleveFrais.tarifFrais.typeFrais',
            'recu',
            'annulation.utilisateur',
        ]);

        return view('frais.paiements.show', compact('paiement'));
    }

    /**
     * Annuler un paiement sans le supprimer.
     */
    public function annuler(Request $request, Paiement $paiement)
    {
        $this->verifierPermission('frais.paiements_annuler');

        $donnees = $request->validate([
            'motif' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ], [
            'motif.required' => 'Le motif de l’annulation est obligatoire.',
            'motif.min'      => 'Le motif doit contenir au moins 5 caractères.',
        ]);

        DB::transaction(function () use ($paiement, $donnees) {
            $paiement = Paiement::whereKey($paiement->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($paiement->statut === 'annule') {
                abort(422, 'Ce paiement est déjà annulé.');
            }

            // Verrouiller les frais concernés.
            $details = DetailPaiement::where('paiement_id', $paiement->id)
                ->with('eleveFrais')
                ->get();

            $idsFrais = $details
                ->pluck('eleve_frais_id')
                ->unique()
                ->values();

            $lignes = EleveFrais::whereIn('id', $idsFrais)
                ->lockForUpdate()
                ->get();

            // Conserver la trace de l'annulation.
            AnnulationPaiement::create([
                'paiement_id'     => $paiement->id,
                'user_id'         => auth()->id(),
                'motif'           => $donnees['motif'],
                'date_annulation' => now(),
            ]);

            $paiement->update([
                'statut' => 'annule',
            ]);

            // Recalculer les statuts des frais concernés.
            foreach ($lignes as $ligne) {
                $montantPaye = $this->montantDejaPaye($ligne);

                $ligne->update([
                    'statut' => $this->determinerStatut(
                        (float) $ligne->montant_du,
                        $montantPaye
                    ),
                ]);
            }
        });

        return redirect()
            ->route('frais.paiements.show', $paiement)
            ->with('success', 'Le paiement a été annulé. Son historique est conservé.');
    }
}