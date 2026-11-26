<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EspaceParentController extends Controller
{
    /**
     * Tableau de bord personnel du parent.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Récupérer la fiche parent liée au compte connecté.
        $parent = $user->parentEleve;

        // Un compte sans fiche parent ne peut pas accéder à cet espace.
        abort_if(
            ! $parent,
            403,
            'Aucune fiche parent n’est associée à votre compte.'
        );

        // Charger uniquement les enfants de ce parent.
        $parent->load([
            'eleves' => function ($query) {
                $query->orderBy('nom')
                    ->orderBy('prenom');
            },
        ]);

        return view('parent.dashboard', compact('parent'));
    }

    /**
     * Consulter les informations d'un de ses enfants.
     */
    public function mesEnfants(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_if(! $parent, 403);

        $eleves = $parent->eleves()
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('parent.enfants', compact('parent', 'eleves'));
    }
}
