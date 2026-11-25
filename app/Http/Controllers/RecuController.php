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
            'paiement.eleve.classe',
            'paiement.utilisateur',
        ])->latest('date_emission');

        if ($request->filled('recherche')) {
            $recherche = trim($request->recherche);

            $query->where(function ($q) use ($recherche) {
                $q->where('numero_recu', 'like', "%{$recherche}%")
                    ->orWhereHas('paiement', function ($paiementQuery) use ($recherche) {
                        $paiementQuery
                            ->where('numero_paiement', 'like', "%{$recherche}%")
                            ->orWhereHas('eleve', function ($eleveQuery) use ($recherche) {
                                $eleveQuery
                                    ->where('nom', 'like', "%{$recherche}%")
                                    ->orWhere('prenom', 'like', "%{$recherche}%")
                                    ->orWhere('matricule', 'like', "%{$recherche}%");
                            });
                    });
            });
        }

        $recus = $query->paginate(15)->withQueryString();

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