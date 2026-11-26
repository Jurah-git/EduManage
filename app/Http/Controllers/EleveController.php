<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EleveController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES ÉLÈVES
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $user = auth()->user();

        // PORTAIL PARENT : uniquement ses propres enfants.
        if ($this->estParent()) {
            $parent = $user->parentEleve()->first();

            if (! $parent) {
                abort(403, 'Aucun dossier parent associé à ce compte.');
            }

            $query = $parent->eleves()->with('classe');

            $this->appliquerFiltres($query, $request);

            $eleves = $query->get();

            // Le parent ne voit que les classes de ses enfants.
            $classes = Classe::whereIn(
                'id',
                $eleves->pluck('classe_id')->filter()->unique()
            )->get();

            return view('eleves.index', compact('eleves', 'classes'));
        }

        // AUTRES UTILISATEURS
        $this->verifierPermission('eleves.voir');

        $query = Eleve::with('classe');

        $this->appliquerFiltres($query, $request);

        $eleves = $query->get();
        $classes = Classe::all();

        return view('eleves.index', compact('eleves', 'classes'));
    }

    /*
    |--------------------------------------------------------------------------
    | FILTRES ET TRI
    |--------------------------------------------------------------------------
    */

    private function appliquerFiltres($query, Request $request): void
    {
        if ($request->nom) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        if ($request->prenom) {
            $query->where('prenom', 'like', '%' . $request->prenom . '%');
        }

        if ($request->classe_id) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->numero_classe) {
            $query->where('numero_classe', $request->numero_classe);
        }

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
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE CRÉATION
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->interdireParent();
        $this->verifierPermission('eleves.creer');

        $classes = Classe::all();

        return view('eleves.create', compact('classes'));
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UN ÉLÈVE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $this->interdireParent();
        $this->verifierPermission('eleves.creer');

        $request->validate([
            'nom'       => 'required',
            'prenom'    => 'required',
            'classe_id' => 'required',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('eleves', 'public');
        }

        $lastEleve = Eleve::latest()->first();

        $nextId = $lastEleve ? $lastEleve->id + 1 : 1;

        $matricule = 'ELV-' . date('Y') . '-' .
            str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $lastNumero = Eleve::where(
            'classe_id',
            $request->classe_id
        )->max('numero_classe');

        $numeroClasse = $lastNumero ? $lastNumero + 1 : 1;

        Eleve::create([
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'matricule'      => $matricule,
            'sexe'           => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'classe_id'      => $request->classe_id,
            'numero_classe'  => $numeroClasse,
            'photo'          => $photoPath,
        ]);

        return redirect()
            ->route('eleves.index')
            ->with('success', 'Élève ajouté avec succès');
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(Eleve $eleve)
    {
        $this->interdireParent();
        $this->verifierPermission('eleves.modifier');

        $classes = Classe::all();

        return view('eleves.edit', compact('eleve', 'classes'));
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFIER UN ÉLÈVE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Eleve $eleve)
    {
        $this->interdireParent();
        $this->verifierPermission('eleves.modifier');

        $request->validate([
            'nom'       => 'required',
            'prenom'    => 'required',
            'classe_id' => 'required',
        ]);

        $photoPath = $eleve->photo;

        if ($request->hasFile('photo')) {
            if (
                $eleve->photo &&
                Storage::disk('public')->exists($eleve->photo)
            ) {
                Storage::disk('public')->delete($eleve->photo);
            }

            $photoPath = $request->file('photo')->store('eleves', 'public');
        }

        $ancienneClasse = $eleve->classe_id;

        if ($ancienneClasse != $request->classe_id) {
            $anciens = Eleve::where('classe_id', $ancienneClasse)
                ->where('id', '!=', $eleve->id)
                ->orderBy('numero_classe')
                ->get();

            foreach ($anciens as $index => $e) {
                $e->update([
                    'numero_classe' => $index + 1,
                ]);
            }

            $lastNumero = Eleve::where(
                'classe_id',
                $request->classe_id
            )->max('numero_classe');

            $nouveauNumero = $lastNumero ? $lastNumero + 1 : 1;
        } else {
            $nouveauNumero = $eleve->numero_classe;
        }

        $eleve->update([
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'sexe'           => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'classe_id'      => $request->classe_id,
            'numero_classe'  => $nouveauNumero,
            'photo'          => $photoPath,
        ]);

        return redirect()
            ->route('eleves.index')
            ->with('success', 'Élève modifié');
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER UN ÉLÈVE
    |--------------------------------------------------------------------------
    */

    public function destroy(Eleve $eleve)
    {
        $this->interdireParent();
        $this->verifierPermission('eleves.supprimer');

        $classeId = $eleve->classe_id;

        if (
            $eleve->photo &&
            Storage::disk('public')->exists($eleve->photo)
        ) {
            Storage::disk('public')->delete($eleve->photo);
        }

        $eleve->delete();

        $eleves = Eleve::where('classe_id', $classeId)
            ->orderBy('numero_classe')
            ->get();

        foreach ($eleves as $index => $e) {
            $e->update([
                'numero_classe' => $index + 1,
            ]);
        }

        return back()->with('success', 'Élève supprimé');
    }

    /*
    |--------------------------------------------------------------------------
    | AFFICHER UNE FICHE ÉLÈVE
    |--------------------------------------------------------------------------
    */

    public function show(Eleve $eleve)
    {
        if ($this->estParent()) {
            $parent = auth()->user()->parentEleve()->first();

            if (! $parent) {
                abort(403, 'Aucun dossier parent associé à ce compte.');
            }

            // Vérifier que cet élève appartient au parent connecté.
            $autorise = $parent->eleves()
                ->where('eleves.id', $eleve->id)
                ->exists();

            if (! $autorise) {
                abort(403, 'Vous ne pouvez pas consulter cet élève.');
            }
        } else {
            $this->verifierPermission('eleves.voir');
        }

        $eleve->load('classe');

        return view('eleves.show', compact('eleve'));
    }

    /*
    |--------------------------------------------------------------------------
    | IDENTIFIER LE RÔLE PARENT
    |--------------------------------------------------------------------------
    */

    private function estParent(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        // L'administrateur principal conserve ses droits.
        if (
            (int) $user->id === 1 ||
            $user->hasRole('Administrateur')
        ) {
            return false;
        }

        return $user->hasRole('Parent');
    }

    /*
    |--------------------------------------------------------------------------
    | INTERDIRE LES OPÉRATIONS D'ÉCRITURE AUX PARENTS
    |--------------------------------------------------------------------------
    */

    private function interdireParent(): void
    {
        if ($this->estParent()) {
            abort(403, 'Les parents ne peuvent pas modifier les dossiers des élèves.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION DES PERMISSIONS
    |--------------------------------------------------------------------------
    */

    private function verifierPermission(string $permission): void
    {
        $user = auth()->user();

        if (! $user || ! $user->aPermission($permission)) {
            abort(403, 'Vous n’avez pas la permission nécessaire pour cette action.');
        }
    }
}
