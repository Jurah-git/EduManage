<?php
namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\EleveFrais;
use App\Models\Inscription;
use App\Models\TarifFrais;
use App\Models\TypeFrais;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenerationFraisController extends Controller
{
    /**
     * Vérifier les permissions.
     */
    private function verifierPermission(string $permission): void
    {
        $user = auth()->user();

        abort_unless(
            $user && $user->aPermission($permission),
            403,
            'Vous n’avez pas l’autorisation d’effectuer cette action.'
        );
    }

    /**
     * Afficher le formulaire de génération.
     */
    public function index()
    {
        $this->verifierPermission('frais.tarifs_gerer');

        $annees = AnneeScolaire::orderByDesc('date_debut')->get();

        $classes = Classe::orderBy('nom')->get();

        $types = TypeFrais::where('actif', true)
            ->orderBy('nom')
            ->get();

        $tarifs = TarifFrais::with([
            'typeFrais',
            'anneeScolaire',
            'classe',
        ])
            ->where('actif', true)
            ->get();

        return view('frais.generation.index', compact(
            'annees',
            'classes',
            'types',
            'tarifs'
        ));
    }

    /**
     * Générer les frais des élèves inscrits et validés.
     */
    public function generer(Request $request)
    {
        $this->verifierPermission('frais.tarifs_gerer');

        $validated = $request->validate([
            'tarif_frais_id' => [
                'required',
                'integer',
                'exists:tarifs_frais,id',
            ],
            'mois'           => [
                'required',
                'integer',
                'between:1,12',
            ],
            'annee'          => [
                'required',
                'integer',
                'between:2000,2100',
            ],
            'date_echeance'  => [
                'required',
                'date',
            ],
        ], [
            'tarif_frais_id.required' => 'Veuillez choisir un tarif scolaire.',
            'tarif_frais_id.exists'   => 'Le tarif sélectionné est introuvable.',
            'mois.required'           => 'Veuillez choisir un mois.',
            'mois.between'            => 'Le mois sélectionné est invalide.',
            'annee.required'          => 'Veuillez choisir une année.',
            'date_echeance.required'  => 'La date limite de paiement est obligatoire.',
        ]);

        $tarif = TarifFrais::with([
            'typeFrais',
            'anneeScolaire',
            'classe',
        ])
            ->where('actif', true)
            ->findOrFail($validated['tarif_frais_id']);

        if (! $tarif->typeFrais || ! $tarif->typeFrais->actif) {
            return back()
                ->withInput()
                ->with('error', 'Le type de frais sélectionné est inactif.');
        }

        if ($tarif->typeFrais->frequence !== 'mensuelle') {
            return back()
                ->withInput()
                ->with('error', 'Ce générateur est réservé aux frais mensuels.');
        }

        $anneeScolaire = $tarif->anneeScolaire;

        if (! $anneeScolaire) {
            return back()
                ->withInput()
                ->with('error', 'Aucune année scolaire associée à ce tarif.');
        }

        $mois  = (int) $validated['mois'];
        $annee = (int) $validated['annee'];

        $dateDebutMois = Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
        $dateFinMois   = $dateDebutMois->copy()->endOfMonth();

        $debutAnneeScolaire = Carbon::parse($anneeScolaire->date_debut)->startOfDay();
        $finAnneeScolaire   = Carbon::parse($anneeScolaire->date_fin)->endOfDay();

        // Vérifier que le mois appartient à l'année scolaire.
        if (
            $dateFinMois->lt($debutAnneeScolaire) ||
            $dateDebutMois->gt($finAnneeScolaire)
        ) {
            return back()
                ->withInput()
                ->with('error', 'Le mois sélectionné ne fait pas partie de cette année scolaire.');
        }

        // Vérifier les dates de validité du tarif.
        if (
            ($tarif->date_debut && $dateFinMois->lt(Carbon::parse($tarif->date_debut))) ||
            ($tarif->date_fin && $dateDebutMois->gt(Carbon::parse($tarif->date_fin)))
        ) {
            return back()
                ->withInput()
                ->with('error', 'Le tarif n’est pas valable pour le mois sélectionné.');
        }

        // Vérifier que la date d'échéance est une date valide.
        $dateEcheance = Carbon::parse($validated['date_echeance']);

        if ($dateEcheance->lt($dateDebutMois) || $dateEcheance->gt($dateFinMois)) {
            return back()
                ->withInput()
                ->with('error', 'La date limite doit se situer dans le mois facturé.');
        }

        // Récupérer uniquement les élèves ayant une inscription validée
        // pour la classe et l'année scolaire du tarif.
        $inscriptions = Inscription::where('annee_scolaire_id', $tarif->annee_scolaire_id)
            ->where('classe_id', $tarif->classe_id)
            ->where('statut', 'validee')
            ->with('eleve')
            ->get();

        if ($inscriptions->isEmpty()) {
            return back()
                ->withInput()
                ->with('warning', 'Aucun élève avec une inscription validée dans cette classe pour cette année scolaire.');
        }

        $clePeriode = sprintf('%04d-%02d', $annee, $mois);

        $libelle = sprintf(
            '%s - %s %d',
            $tarif->typeFrais->nom,
            $dateDebutMois->locale('fr')->translatedFormat('F'),
            $annee
        );

        $crees    = 0;
        $doublons = 0;

        DB::transaction(function () use (
            $inscriptions,
            $tarif,
            $clePeriode,
            $libelle,
            $mois,
            $annee,
            $dateEcheance,
            &$crees,
            &$doublons
        ) {
            foreach ($inscriptions as $inscription) {
                if (! $inscription->eleve) {
                    continue;
                }

                $existe = EleveFrais::where('eleve_id', $inscription->eleve_id)
                    ->where('tarif_frais_id', $tarif->id)
                    ->where('cle_periode', $clePeriode)
                    ->exists();

                if ($existe) {
                    $doublons++;
                    continue;
                }

                EleveFrais::create([
                    'eleve_id'       => $inscription->eleve_id,
                    'tarif_frais_id' => $tarif->id,
                    'libelle'        => $libelle,
                    'cle_periode'    => $clePeriode,
                    'montant_du'     => $tarif->montant,
                    'mois'           => $mois,
                    'annee'          => $annee,
                    'date_echeance'  => $dateEcheance->toDateString(),
                    'statut'         => 'impaye',
                ]);

                $crees++;
            }
        });

        return redirect()
            ->route('frais.generation.index')
            ->with('success', "{$crees} frais généré(s) avec succès. {$doublons} doublon(s) ignoré(s).");
    }
}