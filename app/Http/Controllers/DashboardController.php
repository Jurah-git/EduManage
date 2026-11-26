<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ESPACE PARENT
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Parent')) {

            $parent = $user->parentEleve()
                ->with(['eleves.classe'])
                ->first();

            // Bloquer l'accès si le compte n'est associé à aucun parent.
            if (!$parent) {
                abort(403, 'Aucun dossier parent associé à ce compte.');
            }

            // Récupérer uniquement les enfants de ce parent.
            $eleves = $parent->eleves;

            return view('parents.dashboard', compact(
                'parent',
                'eleves'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | ESPACE ADMINISTRATION
        |--------------------------------------------------------------------------
        */

        $totalEleves = Eleve::count();
        $totalClasses = Classe::count();
        $totalUsers = User::count();
        $totalEnseignants = Enseignant::count();

        return view('dashboard', compact(
            'totalEleves',
            'totalClasses',
            'totalUsers',
            'totalEnseignants'
        ));
    }
}