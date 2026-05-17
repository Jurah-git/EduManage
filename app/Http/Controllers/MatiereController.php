<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Matiere;
use App\Models\Classe;

class MatiereController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $matieres = Matiere::with('classes')
            ->latest()
            ->get();

        return view(
            'matieres.index',
            compact('matieres')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $classes = Classe::all();

        return view(
            'matieres.create',
            compact('classes')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'nom' => 'required',

        ]);

        /*
        |--------------------------------------------------------------------------
        | CODE AUTO
        |--------------------------------------------------------------------------
        */

        $last = Matiere::latest()->first();

        $nextId = $last
            ? $last->id + 1
            : 1;

        $code = 'MAT-' .
            str_pad($nextId, 4, '0', STR_PAD_LEFT);

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        $matiere = Matiere::create([

            'code' => $code,
            'nom' => $request->nom,

        ]);

        /*
        |--------------------------------------------------------------------------
        | RELATION CLASSES
        |--------------------------------------------------------------------------
        */

        if ($request->classes) {

            $matiere->classes()->attach(
                $request->classes
            );
        }

        return redirect()
            ->route('matieres.index')
            ->with(
                'success',
                'Matière ajoutée avec succès'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Matiere $matiere)
    {
        $classes = Classe::all();

        return view(
            'matieres.edit',
            compact(
                'matiere',
                'classes'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Matiere $matiere
    ) {
        $request->validate([

            'nom' => 'required',

        ]);

        $matiere->update([

            'nom' => $request->nom,

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE RELATION CLASSES
        |--------------------------------------------------------------------------
        */

        $matiere->classes()->sync(
            $request->classes ?? []
        );

        return redirect()
            ->route('matieres.index')
            ->with(
                'success',
                'Matière modifiée'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Matiere $matiere)
    {
        $matiere->classes()->detach();

        $matiere->delete();

        return back()->with(
            'success',
            'Matière supprimée'
        );
    }
}