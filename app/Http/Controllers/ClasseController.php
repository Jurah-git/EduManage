<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $classes = Classe::withCount('eleves')
            ->latest()
            ->get();

        return view(
            'classes.index',
            compact('classes')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('classes.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:classes,nom',
        ]);

        Classe::create([
            'nom' => $request->nom,
        ]);

        return redirect()
            ->route('classes.index')
            ->with(
                'success',
                'Classe ajoutée avec succès'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Classe $classe)
    {
        return view(
            'classes.edit',
            compact('classe')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Classe $classe
    ) {
        $request->validate([
            'nom' => 'required|unique:classes,nom,' . $classe->id,
        ]);

        $classe->update([
            'nom' => $request->nom,
        ]);

        return redirect()
            ->route('classes.index')
            ->with(
                'success',
                'Classe modifiée avec succès'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Classe $classe)
    {
        /*
        |--------------------------------------------------------------------------
        | VERIFIER SI DES ELEVES EXISTENT
        |--------------------------------------------------------------------------
        */

        if ($classe->eleves()->count() > 0) {

            return back()->with(
                'error',
                'Impossible de supprimer cette classe car elle contient des élèves.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DETACH MATIERES
        |--------------------------------------------------------------------------
        */

        $classe->matieres()->detach();

        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        $classe->delete();

        return back()->with(
            'success',
            'Classe supprimée avec succès'
        );
    }
}
