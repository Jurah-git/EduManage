<?php
namespace App\Http\Controllers;

use App\Models\TypeFrais;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeFraisController extends Controller
{
    /**
     * Vérifier la permission de l'utilisateur connecté.
     */
    private function verifierPermission(string $permission): void
    {
        $user = auth()->user();

        abort_unless(
            $user && $user->aPermission($permission),
            403,
            'Vous n’avez pas l’autorisation d’effectuer cette action.'
        );
    }

    /**
     * Liste des types de frais.
     */
    /**
     * Liste des types de frais avec recherche et filtres.
     */
    public function index(Request $request)
    {
        $this->verifierPermission('frais.types_voir');

        // Récupérer les critères de recherche.
        $recherche = $request->input('recherche');
        $frequence = $request->input('frequence');
        $statut    = $request->input('statut');

        // Construire la requête.
        $query = TypeFrais::query();

        // Recherche par nom ou description.
        if (! empty($recherche)) {
            $query->where(function ($q) use ($recherche) {
                $q->where('nom', 'LIKE', "%{$recherche}%")
                    ->orWhere('description', 'LIKE', "%{$recherche}%");
            });
        }

        // Filtrer par fréquence.
        if (in_array($frequence, [
            'unique',
            'mensuelle',
            'trimestrielle',
            'annuelle',
        ])) {
            $query->where('frequence', $frequence);
        }

        // Filtrer par statut.
        if ($statut === 'actif') {
            $query->where('actif', true);
        } elseif ($statut === 'inactif') {
            $query->where('actif', false);
        }

        // Liste paginée.
        $types = $query
            ->orderBy('nom')
            ->paginate(10)
            ->withQueryString();

        // Statistiques générales.
        $totalTypes    = TypeFrais::count();
        $totalActifs   = TypeFrais::where('actif', true)->count();
        $totalInactifs = TypeFrais::where('actif', false)->count();

        return view('frais.types.index', compact(
            'types',
            'recherche',
            'frequence',
            'statut',
            'totalTypes',
            'totalActifs',
            'totalInactifs'
        ));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $this->verifierPermission('frais.types_creer');

        return view('frais.types.create');
    }

    /**
     * Enregistrer un nouveau type de frais.
     */
    public function store(Request $request)
    {
        $this->verifierPermission('frais.types_creer');

        $validated = $request->validate([
            'nom'         => [
                'required',
                'string',
                'max:150',
                'unique:types_frais,nom',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'frequence'   => [
                'required',
                Rule::in([
                    'unique',
                    'mensuelle',
                    'trimestrielle',
                    'annuelle',
                ]),
            ],
            'actif'       => [
                'nullable',
                'boolean',
            ],
        ], [
            'nom.required'       => 'Le nom du type de frais est obligatoire.',
            'nom.unique'         => 'Ce type de frais existe déjà.',
            'nom.max'            => 'Le nom ne doit pas dépasser 150 caractères.',
            'description.max'    => 'La description ne doit pas dépasser 1000 caractères.',
            'frequence.required' => 'Veuillez choisir une fréquence.',
            'frequence.in'       => 'La fréquence sélectionnée est invalide.',
        ]);

        $validated['actif'] = $request->boolean('actif');

        TypeFrais::create($validated);

        return redirect()
            ->route('frais.types.index')
            ->with('success', 'Type de frais ajouté avec succès.');
    }

    /**
     * Afficher un type de frais.
     */
    public function show(string $id)
    {
        $this->verifierPermission('frais.types_voir');

        $type = TypeFrais::with([
            'tarifs.anneeScolaire',
            'tarifs.classe',
        ])->findOrFail($id);

        return view('frais.types.show', compact('type'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(string $id)
    {
        $this->verifierPermission('frais.types_modifier');

        $type = TypeFrais::findOrFail($id);

        return view('frais.types.edit', compact('type'));
    }

    /**
     * Mettre à jour un type de frais.
     */
    public function update(Request $request, string $id)
    {
        $this->verifierPermission('frais.types_modifier');

        $type = TypeFrais::findOrFail($id);

        $validated = $request->validate([
            'nom'         => [
                'required',
                'string',
                'max:150',
                Rule::unique('types_frais', 'nom')->ignore($type->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'frequence'   => [
                'required',
                Rule::in([
                    'unique',
                    'mensuelle',
                    'trimestrielle',
                    'annuelle',
                ]),
            ],
            'actif'       => [
                'nullable',
                'boolean',
            ],
        ], [
            'nom.required'       => 'Le nom du type de frais est obligatoire.',
            'nom.unique'         => 'Ce type de frais existe déjà.',
            'nom.max'            => 'Le nom ne doit pas dépasser 150 caractères.',
            'description.max'    => 'La description ne doit pas dépasser 1000 caractères.',
            'frequence.required' => 'Veuillez choisir une fréquence.',
            'frequence.in'       => 'La fréquence sélectionnée est invalide.',
        ]);

        $validated['actif'] = $request->boolean('actif');

        $type->update($validated);

        return redirect()
            ->route('frais.types.index')
            ->with('success', 'Type de frais modifié avec succès.');
    }

    /**
     * Supprimer un type de frais.
     */
    public function destroy(string $id)
    {
        $this->verifierPermission('frais.types_supprimer');

        $type = TypeFrais::findOrFail($id);

        // Empêcher la suppression si le type possède déjà des tarifs.
        if ($type->tarifs()->exists()) {
            return redirect()
                ->route('frais.types.index')
                ->with(
                    'error',
                    'Impossible de supprimer ce type de frais : il est déjà associé à un ou plusieurs tarifs scolaires.'
                );
        }

        $type->delete();

        return redirect()
            ->route('frais.types.index')
            ->with('success', 'Type de frais supprimé avec succès.');
    }
}