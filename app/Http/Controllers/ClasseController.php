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

    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [10, 15, 25, 50])) {
            $perPage = 10;
        }

        $classes = Classe::withCount('eleves')
            ->orderBy('nom')
            ->paginate($perPage)
            ->withQueryString();

        return view('classes.index', compact(
            'classes',
            'perPage'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        abort_unless(auth()->user()->aPermission('classes.creer'), 403);

        return view('classes.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->aPermission('classes.creer'), 403);

        $request->validate([
            'nom' => 'required|unique:classes,nom',
        ]);

        Classe::create([
            'nom' => $request->nom,
        ]);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe ajoutée avec succès');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Classe $classe)
    {
        abort_unless(auth()->user()->aPermission('classes.modifier'), 403);

        return view('classes.edit', compact('classe'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Classe $classe)
    {
        abort_unless(auth()->user()->aPermission('classes.modifier'), 403);

        $request->validate([
            'nom' => 'required|unique:classes,nom,' . $classe->id,
        ]);

        $classe->update([
            'nom' => $request->nom,
        ]);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Classe modifiée avec succès');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Classe $classe)
    {
        abort_unless(auth()->user()->aPermission('classes.supprimer'), 403);

        if ($classe->eleves()->count() > 0) {
            return back()->with(
                'error',
                'Impossible de supprimer cette classe car elle contient des élèves.'
            );
        }

        $classe->matieres()->detach();

        $classe->delete();

        return back()->with(
            'success',
            'Classe supprimée avec succès'
        );
    }
}