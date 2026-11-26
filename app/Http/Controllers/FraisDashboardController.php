<?php
namespace App\Http\Controllers;

use App\Models\EleveFrais;
use App\Models\Paiement;

class FraisDashboardController extends Controller
{
    /**
     * Tableau de bord financier
     */
    public function index()
    {
        $user = auth()->user();

        // Vérification de la permission
        abort_unless(
            $user && $user->aPermission('frais.dashboard'),
            403,
            'Vous n’avez pas la permission d’accéder au tableau de bord financier.'
        );

        /*
        |--------------------------------------------------------------------------
        | 1. STATISTIQUES DES PAIEMENTS
        |--------------------------------------------------------------------------
        */

        // Total encaissé depuis le début
        $totalEncaisse = Paiement::where('statut', 'valide')
            ->sum('montant_total');

        // Total encaissé pendant le mois actuel
        $totalEncaisseMois = Paiement::where('statut', 'valide')
            ->whereYear('date_paiement', now()->year)
            ->whereMonth('date_paiement', now()->month)
            ->sum('montant_total');

        // Total des paiements annulés
        $totalAnnule = Paiement::where('statut', 'annule')
            ->sum('montant_total');

        // Nombre de paiements validés
        $nombrePaiements = Paiement::where('statut', 'valide')
            ->count();

        // Nombre de paiements validés ce mois
        $nombrePaiementsMois = Paiement::where('statut', 'valide')
            ->whereYear('date_paiement', now()->year)
            ->whereMonth('date_paiement', now()->month)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 2. FRAIS IMPAYÉS ET PARTIELLEMENT PAYÉS
        |--------------------------------------------------------------------------
        */

        $fraisEnAttente = EleveFrais::with([
            'eleve.classe',
            'tarifFrais.typeFrais',
        ])
            ->withSum([
                'detailsPaiements as montant_regle' => function ($query) {
                    $query->whereHas('paiement', function ($paiement) {
                        $paiement->where('statut', 'valide');
                    });
                },
            ], 'montant_paye')
            ->whereIn('statut', ['impaye', 'partiel'])
            ->get();

        // Calcul du reste à payer en tenant compte des paiements validés
        $totalResteARecouvrer = $fraisEnAttente->sum(function ($frais) {
            $montantDu    = (float) $frais->montant_du;
            $montantRegle = (float) ($frais->montant_regle ?? 0);

            return max(0, $montantDu - $montantRegle);
        });

        // Nombre de frais totalement impayés
        $nombreFraisImpayes = $fraisEnAttente
            ->where('statut', 'impaye')
            ->count();

        // Nombre de frais partiellement payés
        $nombreFraisPartiels = $fraisEnAttente
            ->where('statut', 'partiel')
            ->count();

        // Nombre d'élèves ayant encore un solde à payer
        $nombreElevesAvecSolde = $fraisEnAttente
            ->filter(function ($frais) {
                $montantDu    = (float) $frais->montant_du;
                $montantRegle = (float) ($frais->montant_regle ?? 0);

                return ($montantDu - $montantRegle) > 0;
            })
            ->pluck('eleve_id')
            ->unique()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 3. DERNIERS PAIEMENTS
        |--------------------------------------------------------------------------
        */

        $derniersPaiements = Paiement::with([
            'eleve.classe',
            'utilisateur',
            'recu',
        ])
            ->latest('date_paiement')
            ->latest('id')
            ->take(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 4. ÉVOLUTION DES ENCAISSEMENTS SUR 6 MOIS
        |--------------------------------------------------------------------------
        */

        $debutPeriode = now()->copy()
            ->startOfMonth()
            ->subMonths(5);

        $encaissementsParMois = Paiement::selectRaw('
                YEAR(date_paiement) as annee,
                MONTH(date_paiement) as mois,
                SUM(montant_total) as total
            ')
            ->where('statut', 'valide')
            ->whereBetween('date_paiement', [
                $debutPeriode,
                now(),
            ])
            ->groupByRaw('YEAR(date_paiement), MONTH(date_paiement)')
            ->orderByRaw('YEAR(date_paiement), MONTH(date_paiement)')
            ->get()
            ->keyBy(function ($ligne) {
                return $ligne->annee . '-' . $ligne->mois;
            });

        $labelsMois   = [];
        $montantsMois = [];

        for ($i = 0; $i < 6; $i++) {
            $date = $debutPeriode->copy()->addMonths($i);

            $cle = $date->year . '-' . $date->month;

            $labelsMois[] = $date->format('m/Y');

            $montantsMois[] = (float) (
                $encaissementsParMois->get($cle)->total ?? 0
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 5. TRANSMISSION À LA VUE
        |--------------------------------------------------------------------------
        */

        return view('frais.dashboard', compact(
            'totalEncaisse',
            'totalEncaisseMois',
            'totalAnnule',
            'nombrePaiements',
            'nombrePaiementsMois',
            'totalResteARecouvrer',
            'nombreFraisImpayes',
            'nombreFraisPartiels',
            'nombreElevesAvecSolde',
            'fraisEnAttente',
            'derniersPaiements',
            'labelsMois',
            'montantsMois'
        ));
    }
}