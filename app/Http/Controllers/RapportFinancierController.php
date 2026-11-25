<?php
namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\DetailPaiement;
use App\Models\EleveFrais;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RapportFinancierController extends Controller
{
    /**
     * Vérifier les permissions.
     */
    private function verifierPermission(): void
    {
        $user = auth()->user();

        abort_unless(
            $user && $user->aPermission('frais.rapports_voir'),
            403,
            'Vous n’avez pas la permission de consulter les rapports financiers.'
        );
    }

    /**
     * Appliquer les filtres sur les détails des paiements.
     */
    private function filtrerDetails(Builder $query, array $filtres): Builder
    {
        return $query
            ->whereHas('paiement', function ($q) use ($filtres) {
                $q->where('statut', 'valide')
                    ->when($filtres['date_debut'], function ($q, $date) {
                        $q->whereDate('date_paiement', '>=', $date);
                    })
                    ->when($filtres['date_fin'], function ($q, $date) {
                        $q->whereDate('date_paiement', '<=', $date);
                    })
                    ->when($filtres['user_id'], function ($q, $id) {
                        $q->where('user_id', $id);
                    });
            })
            ->whereHas('eleveFrais.tarifFrais', function ($q) use ($filtres) {
                $q->when($filtres['annee_scolaire_id'], function ($q, $id) {
                    $q->where('annee_scolaire_id', $id);
                })
                    ->when($filtres['classe_id'], function ($q, $id) {
                        $q->where('classe_id', $id);
                    });
            });
    }

    /**
     * Tableau de bord des rapports financiers.
     */
    public function index(Request $request)
    {
        $this->verifierPermission();

        $request->validate([
            'date_debut'        => ['nullable', 'date'],
            'date_fin'          => ['nullable', 'date', 'after_or_equal:date_debut'],
            'annee_scolaire_id' => ['nullable', 'exists:annees_scolaires,id'],
            'classe_id'         => ['nullable', 'exists:classes,id'],
            'user_id'           => ['nullable', 'exists:users,id'],
        ]);

        $filtres = [
            'date_debut'        => $request->date_debut,
            'date_fin'          => $request->date_fin,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'classe_id'         => $request->classe_id,
            'user_id'           => $request->user_id,
        ];

        /*
        |--------------------------------------------------------------------------
        | Informations des filtres
        |--------------------------------------------------------------------------
        */

        $anneesScolaires = AnneeScolaire::orderByDesc('date_debut')->get();

        $classes = Classe::orderBy('nom')->get();

        $caissiers = User::whereIn(
            'id',
            Paiement::select('user_id')
                ->whereNotNull('user_id')
                ->distinct()
        )->orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | Base des détails des paiements validés
        |--------------------------------------------------------------------------
        */

        $details = $this->filtrerDetails(
            DetailPaiement::query(),
            $filtres
        );

        /*
        |--------------------------------------------------------------------------
        | Total des encaissements
        |--------------------------------------------------------------------------
        */

        $totalEncaisse = (clone $details)->sum('montant_paye');

        $nombrePaiements = (clone $details)
            ->distinct()
            ->count('paiement_id');

        /*
        |--------------------------------------------------------------------------
        | Encaissements par jour
        |--------------------------------------------------------------------------
        */

        $encaissementsJournaliers = (clone $details)
            ->join('paiements', 'details_paiements.paiement_id', '=', 'paiements.id')
            ->selectRaw('DATE(paiements.date_paiement) as date, SUM(details_paiements.montant_paye) as total')
            ->groupBy(DB::raw('DATE(paiements.date_paiement)'))
            ->orderByDesc('date')
            ->limit(15)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Encaissements par mois
        |--------------------------------------------------------------------------
        */

        $encaissementsMensuels = (clone $details)
            ->join('paiements', 'details_paiements.paiement_id', '=', 'paiements.id')
            ->selectRaw("DATE_FORMAT(paiements.date_paiement, '%Y-%m') as mois, SUM(details_paiements.montant_paye) as total")
            ->groupBy(DB::raw("DATE_FORMAT(paiements.date_paiement, '%Y-%m')"))
            ->orderBy('mois')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Encaissements par classe
        |--------------------------------------------------------------------------
        */

        $encaissementsParClasse = (clone $details)
            ->join('eleves_frais', 'details_paiements.eleve_frais_id', '=', 'eleves_frais.id')
            ->join('tarifs_frais', 'eleves_frais.tarif_frais_id', '=', 'tarifs_frais.id')
            ->join('classes', 'tarifs_frais.classe_id', '=', 'classes.id')
            ->selectRaw('classes.id, classes.nom, SUM(details_paiements.montant_paye) as total')
            ->groupBy('classes.id', 'classes.nom')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Encaissements par caissier
        |--------------------------------------------------------------------------
        */

        $encaissementsParCaissier = (clone $details)
            ->join('paiements', 'details_paiements.paiement_id', '=', 'paiements.id')
            ->join('users', 'paiements.user_id', '=', 'users.id')
            ->selectRaw('users.id, users.name, SUM(details_paiements.montant_paye) as total')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Frais impayés et partiellement payés
        |--------------------------------------------------------------------------
        */

        $fraisEnAttente = EleveFrais::with([
            'eleve.classe',
            'tarifFrais.anneeScolaire',
            'detailsPaiements.paiement',
        ])
            ->whereIn('statut', ['impaye', 'partiel'])
            ->whereHas('tarifFrais', function ($q) use ($filtres) {
                $q->when($filtres['annee_scolaire_id'], function ($q, $id) {
                    $q->where('annee_scolaire_id', $id);
                })
                    ->when($filtres['classe_id'], function ($q, $id) {
                        $q->where('classe_id', $id);
                    });
            })
            ->get()
            ->map(function ($frais) {
                $montantRegle = $frais->detailsPaiements
                    ->filter(fn($detail) => $detail->paiement?->statut === 'valide')
                    ->sum('montant_paye');

                $frais->montant_regle = $montantRegle;
                $frais->reste_a_payer = max(
                    0,
                    (float) $frais->montant_du - $montantRegle
                );

                return $frais;
            })
            ->filter(fn($frais) => $frais->reste_a_payer > 0)
            ->values();

        $totalImpayes = $fraisEnAttente->sum('reste_a_payer');

        $nombreFraisImpayes = $fraisEnAttente
            ->where('statut', 'impaye')
            ->count();

        $nombreFraisPartiels = $fraisEnAttente
            ->where('statut', 'partiel')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Paiements annulés
        |--------------------------------------------------------------------------
        */

        $paiementsAnnules = Paiement::with([
            'eleve.classe',
            'utilisateur',
            'annulation',
        ])
            ->where('statut', 'annule')
            ->when($filtres['date_debut'], function ($q, $date) {
                $q->whereDate('date_paiement', '>=', $date);
            })
            ->when($filtres['date_fin'], function ($q, $date) {
                $q->whereDate('date_paiement', '<=', $date);
            })
            ->when($filtres['user_id'], function ($q, $id) {
                $q->where('user_id', $id);
            })
            ->whereHas('details.eleveFrais.tarifFrais', function ($q) use ($filtres) {
                $q->when($filtres['annee_scolaire_id'], function ($q, $id) {
                    $q->where('annee_scolaire_id', $id);
                })
                    ->when($filtres['classe_id'], function ($q, $id) {
                        $q->where('classe_id', $id);
                    });
            })
            ->latest('date_paiement')
            ->get();

        $totalAnnule = $paiementsAnnules->sum('montant_total');

        /*
        |--------------------------------------------------------------------------
        | Affichage
        |--------------------------------------------------------------------------
        */

        return view('frais.rapports.index', compact(
            'filtres',
            'anneesScolaires',
            'classes',
            'caissiers',
            'totalEncaisse',
            'nombrePaiements',
            'encaissementsJournaliers',
            'encaissementsMensuels',
            'encaissementsParClasse',
            'encaissementsParCaissier',
            'fraisEnAttente',
            'totalImpayes',
            'nombreFraisImpayes',
            'nombreFraisPartiels',
            'paiementsAnnules',
            'totalAnnule'
        ));
    }
}