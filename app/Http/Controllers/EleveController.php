<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EleveController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Eleve::with('classe');

        /*
    |--------------------------------------------------------------------------
    | FILTRE NOM
    |--------------------------------------------------------------------------
    */

        if ($request->nom) {

            $query->where(
                'nom',
                'like',
                '%' . $request->nom . '%'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | FILTRE PRENOM
    |--------------------------------------------------------------------------
    */

        if ($request->prenom) {

            $query->where(
                'prenom',
                'like',
                '%' . $request->prenom . '%'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | FILTRE CLASSE
    |--------------------------------------------------------------------------
    */

        if ($request->classe_id) {

            $query->where(
                'classe_id',
                $request->classe_id
            );
        }

        /*
    |--------------------------------------------------------------------------
    | FILTRE NUMERO
    |--------------------------------------------------------------------------
    */

        if ($request->numero_classe) {

            $query->where(
                'numero_classe',
                $request->numero_classe
            );
        }

        /*
    |--------------------------------------------------------------------------
    | TRI
    |--------------------------------------------------------------------------
    */

        $sort = $request->sort ?? 'nom_asc';

        switch ($sort) {

            case 'nom_desc':
                $query->orderBy('nom', 'desc');
                break;

            case 'prenom_asc':
                $query->orderBy('prenom', 'asc');
                break;

            case 'prenom_desc':
                $query->orderBy('prenom', 'desc');
                break;

            case 'numero_asc':
                $query->orderBy('numero_classe', 'asc');
                break;

            case 'numero_desc':
                $query->orderBy('numero_classe', 'desc');
                break;

            default:
                $query->orderBy('nom', 'asc');
                break;
        }

        $eleves = $query->get();

        $classes = Classe::all();

        return view(
            'eleves.index',
            compact('eleves', 'classes')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $classes = Classe::all();

        return view('eleves.create', compact('classes'));
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
            'prenom' => 'required',
            'classe_id' => 'required',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PHOTO
        |--------------------------------------------------------------------------
        */

        $photoPath = null;

        if ($request->hasFile('photo')) {

            $photoPath = $request
                ->file('photo')
                ->store('eleves', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | MATRICULE AUTO
        |--------------------------------------------------------------------------
        */

        $lastEleve = Eleve::latest()->first();

        $nextId = $lastEleve
            ? $lastEleve->id + 1
            : 1;

        $matricule = 'ELV-' .
            date('Y') . '-' .
            str_pad($nextId, 4, '0', STR_PAD_LEFT);

        /*
    |--------------------------------------------------------------------------
    | NUMERO CLASSE AUTO
    |--------------------------------------------------------------------------
    */

        $lastNumero = Eleve::where(
            'classe_id',
            $request->classe_id
        )->max('numero_classe');

        $numeroClasse = $lastNumero
            ? $lastNumero + 1
            : 1;

        /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

        Eleve::create([

            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'matricule' => $matricule,
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'classe_id' => $request->classe_id,
            'numero_classe' => $numeroClasse,
            'photo' => $photoPath,

        ]);

        return redirect()
            ->route('eleves.index')
            ->with('success', 'Élève ajouté avec succès');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Eleve $eleve)
    {
        $classes = Classe::all();

        return view('eleves.edit', compact(
            'eleve',
            'classes'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Eleve $eleve)
    {
        /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

        $photoPath = $eleve->photo;

        // Nouvelle photo
        if ($request->hasFile('photo')) {

            /*
            |--------------------------------------------------------------------------
            | DELETE OLD PHOTO
            |--------------------------------------------------------------------------
            */

            if (
                $eleve->photo &&
                Storage::disk('public')->exists($eleve->photo)
            ) {

                Storage::disk('public')->delete($eleve->photo);
            }

            /*
            |--------------------------------------------------------------------------
            | STORE NEW PHOTO
            |--------------------------------------------------------------------------
            */

            $photoPath = $request
                ->file('photo')
                ->store('eleves', 'public');
        }

        $ancienneClasse = $eleve->classe_id;

        /*
        |--------------------------------------------------------------------------
        | SI CHANGEMENT DE CLASSE
        |--------------------------------------------------------------------------
        */

        if ($ancienneClasse != $request->classe_id) {

            /*
        |--------------------------------------------------------------------------
        | REORGANISER ANCIENNE CLASSE
        |--------------------------------------------------------------------------
        */

            $anciens = Eleve::where(
                'classe_id',
                $ancienneClasse
            )
                ->where('id', '!=', $eleve->id)
                ->orderBy('numero_classe')
                ->get();

            foreach ($anciens as $index => $e) {

                $e->update([
                    'numero_classe' => $index + 1
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | NOUVEAU NUMERO
        |--------------------------------------------------------------------------
        */

            $lastNumero = Eleve::where(
                'classe_id',
                $request->classe_id
            )->max('numero_classe');

            $nouveauNumero = $lastNumero
                ? $lastNumero + 1
                : 1;
        } else {

            $nouveauNumero = $eleve->numero_classe;
        }

        /*
    |--------------------------------------------------------------------------
    | UPDATE ELEVE
    |--------------------------------------------------------------------------
    */

        $eleve->update([

            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'classe_id' => $request->classe_id,
            'numero_classe' => $nouveauNumero,
            'photo' => $photoPath,

        ]);

        return redirect()
            ->route('eleves.index')
            ->with('success', 'Élève modifié');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Eleve $eleve)
    {
        $classeId = $eleve->classe_id;
        /*
|--------------------------------------------------------------------------
        | DELETE PHOTO
        |--------------------------------------------------------------------------
        */

        if (
            $eleve->photo &&
            Storage::disk('public')->exists($eleve->photo)
        ) {

            Storage::disk('public')->delete($eleve->photo);
        }
        $eleve->delete();

        /*
    |--------------------------------------------------------------------------
    | REORGANISER NUMEROS
    |--------------------------------------------------------------------------
    */

        $eleves = Eleve::where('classe_id', $classeId)
            ->orderBy('numero_classe')
            ->get();

        foreach ($eleves as $index => $e) {

            $e->update([
                'numero_classe' => $index + 1
            ]);
        }

        return back()
            ->with('success', 'Élève supprimé');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Eleve $eleve)
    {
        return view('eleves.show', compact('eleve'));
    }
}
