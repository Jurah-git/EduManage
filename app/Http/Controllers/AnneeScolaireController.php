<?php
namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class AnneeScolaireController extends Controller
{
    /**
     * Afficher la liste des années scolaires.
     */
    public function index()
    {
        $annees = AnneeScolaire::orderByDesc('date_debut')->get();

        return view(
            'config.annee_index',
            compact('annees')
        );
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        return view('config.annee_create');
    }

    /**
     * Enregistrer une nouvelle année scolaire.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nom'        => [
                    'required',
                    'string',
                    'max:50',
                    'unique:annee_scolaires,nom',
                ],

                'date_debut' => [
                    'required',
                    'date',
                ],

                'date_fin'   => [
                    'required',
                    'date',
                    'after:date_debut',
                ],
            ],
            [
                'nom.required'        =>
                'Le nom de l’année scolaire est obligatoire.',

                'nom.unique'          =>
                'Cette année scolaire existe déjà.',

                'date_debut.required' =>
                'La date de début est obligatoire.',

                'date_fin.required'   =>
                'La date de fin est obligatoire.',

                'date_fin.after'      =>
                'La date de fin doit être après la date de début.',
            ]
        );

        AnneeScolaire::create([
            'nom'        => $request->nom,
            'date_debut' => $request->date_debut,
            'date_fin'   => $request->date_fin,
            'active'     => false,
        ]);

        return redirect()
            ->route('config.annees-scolaires.index')
            ->with(
                'success',
                'Année scolaire ajoutée avec succès.'
            );
    }

    /**
     * Afficher les détails d'une année scolaire.
     */
    public function show(AnneeScolaire $anneeScolaire)
    {
        return view(
            'config.annee_show',
            compact('anneeScolaire')
        );
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(AnneeScolaire $anneeScolaire)
    {
        return view(
            'config.annee_edit',
            compact('anneeScolaire')
        );
    }

    /**
     * Modifier une année scolaire.
     */
    public function update(
        Request $request,
        AnneeScolaire $anneeScolaire
    ) {
        $request->validate(
            [
                'nom'        => [
                    'required',
                    'string',
                    'max:50',
                    'unique:annee_scolaires,nom,' . $anneeScolaire->id,
                ],

                'date_debut' => [
                    'required',
                    'date',
                ],

                'date_fin'   => [
                    'required',
                    'date',
                    'after:date_debut',
                ],
            ],
            [
                'nom.required'        =>
                'Le nom de l’année scolaire est obligatoire.',

                'nom.unique'          =>
                'Cette année scolaire existe déjà.',

                'date_debut.required' =>
                'La date de début est obligatoire.',

                'date_fin.required'   =>
                'La date de fin est obligatoire.',

                'date_fin.after'      =>
                'La date de fin doit être après la date de début.',
            ]
        );

        $anneeScolaire->update([
            'nom'        => $request->nom,
            'date_debut' => $request->date_debut,
            'date_fin'   => $request->date_fin,
        ]);

        return redirect()
            ->route('config.annees-scolaires.index')
            ->with(
                'success',
                'Année scolaire modifiée avec succès.'
            );
    }

    /**
     * Supprimer une année scolaire.
     */
    public function destroy(AnneeScolaire $anneeScolaire)
    {
        if ($anneeScolaire->active) {

            return redirect()
                ->route('config.annees-scolaires.index')
                ->with(
                    'error',
                    'Impossible de supprimer l’année scolaire en cours.'
                );
        }

        $anneeScolaire->delete();

        return redirect()
            ->route('config.annees-scolaires.index')
            ->with(
                'success',
                'Année scolaire supprimée avec succès.'
            );
    }

    /**
     * Définir une année scolaire comme année en cours.
     */
    public function activer(AnneeScolaire $anneeScolaire)
    {
        /*
        | Désactiver toutes les années scolaires.
        */

        AnneeScolaire::query()->update([
            'active' => false,
        ]);

        /*
        | Activer l'année sélectionnée.
        */

        $anneeScolaire->update([
            'active' => true,
        ]);

        return redirect()
            ->route('config.annees-scolaires.index')
            ->with(
                'success',
                'L’année scolaire ' .
                $anneeScolaire->nom .
                ' est maintenant l’année en cours.'
            );
    }
}
