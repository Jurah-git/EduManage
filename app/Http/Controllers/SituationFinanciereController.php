<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\EleveFrais;
use Illuminate\Pagination\LengthAwarePaginator;

class SituationFinanciereController extends Controller
{
    /**
     * Vérifier la permission de consultation.
     */
    private function verifierPermission(): void
    {
        $user = auth()->user();

        abort_unless(
            $user && $user->aPermission('frais.situations_voir'),
            403,
            'Vous n’avez pas la permission de consulter les situations financières.'
        );
    }

    /**
     * Vérifier qu'un parent consulte uniquement son propre enfant.
     */
    private function verifierAccesEleve(Eleve $eleve): void
    {
        $user = auth()->user();

        if ($user->hasRole('parent')) {
            $parent = $user->parentEleve;

            abort_unless(
                $parent &&
                $parent->eleves()
                    ->where('eleves.id', $eleve->id)
                    ->exists(),
                403,
                'Vous n’êtes pas autorisé à consulter la situation financière de cet élève.'
            );
        }
    }

    /**
     * Liste des situations financières.
     */

    public function index()
    {
        $this->verifierPermission();

        $user = auth()->user();

        // Liste des élèves
        $query = Eleve::with('classe')
            ->orderBy('nom')
            ->orderBy('prenom');

        // Recherche par nom, prénom ou matricule
        if (request()->filled('recherche')) {
            $recherche = trim(request('recherche'));

            $query->where(function ($q) use ($recherche) {
                $q->where('nom', 'like', "%{$recherche}%")
                    ->orWhere('prenom', 'like', "%{$recherche}%")
                    ->orWhere('matricule', 'like', "%{$recherche}%");
            });
        }

        // Filtre par classe
        if (request()->filled('classe_id')) {
            $query->where('classe_id', request('classe_id'));
        }

        // Restriction pour les parents
        if ($user->hasRole('parent')) {
            $parent = $user->parentEleve;

            if ($parent) {
                $idsEleves = $parent->eleves()->pluck('eleves.id');
                $query->whereIn('id', $idsEleves);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Récupération des élèves correspondant aux critères
        $tousLesEleves = $query->get();

        // Années disponibles dans les frais générés
        $annees = EleveFrais::whereNotNull('annee')
            ->distinct()
            ->orderByDesc('annee')
            ->pluck('annee');

        // Récupération de l'année sélectionnée
        $anneeSelectionnee = request('annee');

        // Récupération des frais des élèves concernés
        $fraisParEleve = EleveFrais::with([
            'detailsPaiements.paiement',
        ])
            ->whereIn('eleve_id', $tousLesEleves->pluck('id'))
            ->when($anneeSelectionnee, function ($q) use ($anneeSelectionnee) {
                $q->where('annee', $anneeSelectionnee);
            })
            ->get()
            ->groupBy('eleve_id');

        // Calcul des situations financières
        foreach ($tousLesEleves as $eleve) {

            $frais = $fraisParEleve->get($eleve->id, collect());

            $totalDu = $frais->sum(function ($ligne) {
                return (float) $ligne->montant_du;
            });

            $totalPaye = $frais->sum(function ($ligne) {
                return $ligne->detailsPaiements->sum(function ($detail) {
                    return $detail->paiement &&
                    $detail->paiement->statut === 'valide'
                        ? (float) $detail->montant_paye
                        : 0;
                });
            });

            $reste = max(0, $totalDu - $totalPaye);

            if ($totalDu <= 0 && $totalPaye <= 0) {
                $statut = 'aucun';
            } elseif ($reste <= 0.009) {
                $statut = 'paye';
            } elseif ($totalPaye > 0) {
                $statut = 'partiel';
            } else {
                $statut = 'impaye';
            }

            $eleve->setAttribute('total_du', $totalDu);
            $eleve->setAttribute('total_paye', $totalPaye);
            $eleve->setAttribute('reste_a_payer', $reste);
            $eleve->setAttribute('statut_calcule', $statut);
        }

        // Filtre par situation financière
        if (request()->filled('statut')) {
            $statutRecherche = request('statut');

            $tousLesEleves = $tousLesEleves
                ->filter(function ($eleve) use ($statutRecherche) {
                    return $eleve->statut_calcule === $statutRecherche;
                })
                ->values();
        }

        // Totaux correspondant aux filtres sélectionnés
        $totalGeneralDu    = $tousLesEleves->sum('total_du');
        $totalGeneralPaye  = $tousLesEleves->sum('total_paye');
        $totalGeneralReste = $tousLesEleves->sum('reste_a_payer');

        // Pagination avec conservation des filtres
        $parPage = 15;
        $page    = LengthAwarePaginator::resolveCurrentPage();

        $eleves = new LengthAwarePaginator(
            $tousLesEleves->forPage($page, $parPage)->values(),
            $tousLesEleves->count(),
            $parPage,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );

        // Classes pour le menu déroulant
        $classes = Classe::orderBy('nom')->get();

        return view('frais.situations.index', compact(
            'eleves',
            'classes',
            'annees',
            'totalGeneralDu',
            'totalGeneralPaye',
            'totalGeneralReste'
        ));
    }

    /**
     * Détails de la situation financière d'un élève.
     */
    public function show(Eleve $eleve)
    {
        $this->verifierPermission();

        $this->verifierAccesEleve($eleve);

        $eleve->load('classe');

        // Récupérer les frais et tout leur historique de paiement.
        $frais = EleveFrais::with([
            'tarifFrais.typeFrais',
            'detailsPaiements.paiement.utilisateur',
            'detailsPaiements.paiement.annulation.utilisateur',
        ])
            ->where('eleve_id', $eleve->id)
            ->orderByDesc('date_echeance')
            ->get();

        $totalDu   = 0;
        $totalPaye = 0;

        foreach ($frais as $ligne) {
            $montantDu = (float) $ligne->montant_du;

            // Seuls les paiements validés sont comptabilisés.
            $montantPaye = $ligne->detailsPaiements->sum(function ($detail) {
                return $detail->paiement &&
                $detail->paiement->statut === 'valide'
                    ? (float) $detail->montant_paye
                    : 0;
            });

            $reste = max(0, $montantDu - $montantPaye);

            $statutCalcule = $reste <= 0.009
                ? 'paye'
                : ($montantPaye > 0 ? 'partiel' : 'impaye');

            $ligne->setAttribute('montant_paye', $montantPaye);
            $ligne->setAttribute('reste_a_payer', $reste);
            $ligne->setAttribute('statut_calcule', $statutCalcule);

            $totalDu   += $montantDu;
            $totalPaye += $montantPaye;
        }

        $resteTotal = max(0, $totalDu - $totalPaye);

        return view('frais.situations.show', compact(
            'eleve',
            'frais',
            'totalDu',
            'totalPaye',
            'resteTotal'
        ));
    }
}