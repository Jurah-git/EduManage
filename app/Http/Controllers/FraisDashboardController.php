<?php
namespace App\Http\Controllers;

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

        // La récupération des statistiques sera ajoutée ensuite.

        return view('frais.dashboard');
    }
}