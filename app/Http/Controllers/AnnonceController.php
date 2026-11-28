<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Liste des annonces pour l'administration.
     */
    public function index()
    {
        $annonces = Annonce::with('auteur')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('annonces.index', compact('annonces'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        return view('annonces.create');
    }

    /**
     * Enregistrer une annonce.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie' => [
                'required',
                'in:information,evenement,reunion,urgence,autre'
            ],
            'contenu' => ['required', 'string'],
            'public_cible' => ['required', 'in:tous,parents'],
            'statut' => ['required', 'in:brouillon,publie'],
            'date_publication' => ['nullable', 'date'],
        ]);

        $validated['user_id'] = Auth::id();

        if ($validated['statut'] === 'publie') {
            $validated['date_publication'] =
                $validated['date_publication'] ?? now();
        } else {
            $validated['date_publication'] = null;
        }

        Annonce::create($validated);

        return redirect()
            ->route('annonces.index')
            ->with('success', 'Annonce créée avec succès.');
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Annonce $annonce)
    {
        return view('annonces.edit', compact('annonce'));
    }

    /**
     * Modifier une annonce.
     */
    public function update(Request $request, Annonce $annonce)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie' => [
                'required',
                'in:information,evenement,reunion,urgence,autre'
            ],
            'contenu' => ['required', 'string'],
            'public_cible' => ['required', 'in:tous,parents'],
            'statut' => ['required', 'in:brouillon,publie'],
            'date_publication' => ['nullable', 'date'],
        ]);

        if ($validated['statut'] === 'publie') {
            $validated['date_publication'] =
                $validated['date_publication']
                ?? $annonce->date_publication
                ?? now();
        } else {
            $validated['date_publication'] = null;
        }

        $annonce->update($validated);

        return redirect()
            ->route('annonces.index')
            ->with('success', 'Annonce modifiée avec succès.');
    }

    /**
     * Publier une annonce.
     */
    public function publier(Annonce $annonce)
    {
        $annonce->update([
            'statut' => 'publie',
            'date_publication' => now(),
        ]);

        return back()->with(
            'success',
            'Annonce publiée avec succès.'
        );
    }

    /**
     * Dépublier une annonce.
     */
    public function depublier(Annonce $annonce)
    {
        $annonce->update([
            'statut' => 'brouillon',
            'date_publication' => null,
        ]);

        return back()->with(
            'success',
            'Annonce retirée de la publication.'
        );
    }

    /**
     * Supprimer une annonce.
     */
    public function destroy(Annonce $annonce)
    {
        $annonce->delete();

        return redirect()
            ->route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}
