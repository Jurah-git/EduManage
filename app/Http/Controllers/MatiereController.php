<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        abort_unless(auth()->user()->aPermission('matieres.voir'), 403);

        $matieres = Matiere::with('classes')
            ->latest()
            ->get();

        return view('matieres.index', compact('matieres'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        abort_unless(auth()->user()->aPermission('matieres.creer'), 403);

        $classes = Classe::all();

        return view('matieres.create', compact('classes'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->aPermission('matieres.creer'), 403);

        $request->validate([
            'nom' => 'required',
        ]);

        // CODE AUTO
        $last = Matiere::latest()->first();

        $nextId = $last
            ? $last->id + 1
            : 1;

        $code = 'MAT-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // CREATE
        $matiere = Matiere::create([
            'code' => $code,
            'nom'  => $request->nom,
        ]);

        // RELATION CLASSES
        if ($request->classes) {
            $matiere->classes()->attach($request->classes);
        }

        return redirect()
            ->route('matieres.index')
            ->with('success', 'Matière ajoutée avec succès');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Matiere $matiere)
    {
        abort_unless(auth()->user()->aPermission('matieres.modifier'), 403);

        $classes = Classe::all();

        return view('matieres.edit', compact('matiere', 'classes'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Matiere $matiere)
    {
        abort_unless(auth()->user()->aPermission('matieres.modifier'), 403);

        $request->validate([
            'nom' => 'required',
        ]);

        $matiere->update([
            'nom' => $request->nom,
        ]);

        // UPDATE RELATION CLASSES
        $matiere->classes()->sync($request->classes ?? []);

        return redirect()
            ->route('matieres.index')
            ->with('success', 'Matière modifiée');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Matiere $matiere)
    {
        abort_unless(auth()->user()->aPermission('matieres.supprimer'), 403);

        $matiere->classes()->detach();

        $matiere->delete();

        return back()->with('success', 'Matière supprimée');
    }
}