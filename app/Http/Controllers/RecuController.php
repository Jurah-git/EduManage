<?php
namespace App\Http\Controllers;

use App\Models\Recu;
use Illuminate\Http\Request;

class RecuController extends Controller
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
            'Vous n’avez pas la permission d’effectuer cette opération.'
        );
    }

    /**
     * Liste des reçus.
     */

    public function index(Request $request)
    {
        $this->verifierPermission('frais.recus_voir');

        $query = Recu::with([
            'paiement.eleve',
        ])->whereHas('paiement');

        // Recherche
        if ($request->filled('recherche')) {
            $recherche = trim($request->recherche);

            $query->where(function ($q) use ($recherche) {
                $q->where('numero_recu', 'like', "%{$recherche}%")
                    ->orWhereHas('paiement', function ($p) use ($recherche) {
                        $p->where('numero_paiement', 'like', "%{$recherche}%")
                            ->orWhereHas('eleve', function ($e) use ($recherche) {
                                $e->where('nom', 'like', "%{$recherche}%")
                                    ->orWhere('prenom', 'like', "%{$recherche}%")
                                    ->orWhere('matricule', 'like', "%{$recherche}%");
                            });
                    });
            });
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->whereHas('paiement', function ($p) use ($request) {
                $p->where('statut', $request->statut);
            });
        }

        // Filtre par mode de paiement
        if ($request->filled('mode_paiement')) {
            $query->whereHas('paiement', function ($p) use ($request) {
                $p->where('mode_paiement', $request->mode_paiement);
            });
        }

        // Filtre par date de début
        if ($request->filled('date_debut')) {
            $query->whereDate('date_emission', '>=', $request->date_debut);
        }

        // Filtre par date de fin
        if ($request->filled('date_fin')) {
            $query->whereDate('date_emission', '<=', $request->date_fin);
        }

        $recus = $query
            ->latest('date_emission')
            ->paginate(15)
            ->withQueryString();

        return view('frais.recus.index', compact('recus'));
    }

    /**
     * Afficher un reçu prêt à imprimer.
     */
    public function imprimer(Recu $recu)
    {
        $this->verifierPermission('frais.recus_imprimer');

        $recu->load([
            'paiement.eleve.classe',
            'paiement.utilisateur',
            'paiement.details.eleveFrais.tarifFrais.typeFrais',
            'paiement.annulation',
        ]);

        abort_unless(
            $recu->paiement,
            404,
            'Le paiement associé à ce reçu est introuvable.'
        );

        return view('frais.recus.imprimer', compact('recu'));
    }
}