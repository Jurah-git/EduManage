<?php
namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\TarifFrais;
use App\Models\TypeFrais;
use Illuminate\Http\Request;

class TarifFraisController extends Controller
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
     * Liste des tarifs scolaires.
     */
    public function index()
    {
        $this->verifierPermission('frais.tarifs_voir');

        $tarifs = TarifFrais::with([
            'typeFrais',
            'anneeScolaire',
            'classe',
        ])
            ->orderByDesc('id')
            ->paginate(10);

        return view('frais.tarifs.index', compact('tarifs'));
    }

    /**
     * Formulaire de création d'un tarif.
     */
    public function create()
    {
        $this->verifierPermission('frais.tarifs_gerer');

        $types = TypeFrais::where('actif', true)
            ->orderBy('nom')
            ->get();

        $annees = AnneeScolaire::orderByDesc('date_debut')
            ->get();

        $classes = Classe::orderBy('nom')
            ->get();

        return view('frais.tarifs.create', compact(
            'types',
            'annees',
            'classes'
        ));
    }

    /**
     * Enregistrer un nouveau tarif.
     */
    public function store(Request $request)
    {
        $this->verifierPermission('frais.tarifs_gerer');

        $validated = $request->validate([
            'type_frais_id'     => [
                'required',
                'exists:types_frais,id',
            ],
            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],
            'classe_id'         => [
                'required',
                'exists:classes,id',
            ],
            'montant'           => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'date_debut'        => [
                'nullable',
                'date',
            ],
            'date_fin'          => [
                'nullable',
                'date',
                'after_or_equal:date_debut',
            ],
            'actif'             => [
                'nullable',
                'boolean',
            ],
        ], [
            'type_frais_id.required'     => 'Veuillez sélectionner un type de frais.',
            'type_frais_id.exists'       => 'Le type de frais sélectionné est invalide.',
            'annee_scolaire_id.required' => 'Veuillez sélectionner une année scolaire.',
            'annee_scolaire_id.exists'   => 'L’année scolaire sélectionnée est invalide.',
            'classe_id.required'         => 'Veuillez sélectionner une classe.',
            'classe_id.exists'           => 'La classe sélectionnée est invalide.',
            'montant.required'           => 'Le montant du tarif est obligatoire.',
            'montant.numeric'            => 'Le montant doit être un nombre valide.',
            'montant.min'                => 'Le montant doit être supérieur à zéro.',
            'date_fin.after_or_equal'    => 'La date de fin doit être postérieure ou égale à la date de début.',
        ]);

        // Vérifier qu'un tarif identique n'existe pas déjà.
        $existe = TarifFrais::where('type_frais_id', $validated['type_frais_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->where('classe_id', $validated['classe_id'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'type_frais_id' => 'Un tarif existe déjà pour ce type de frais, cette année scolaire et cette classe.',
                ]);
        }

        $validated['actif'] = $request->boolean('actif');

        TarifFrais::create($validated);

        return redirect()
            ->route('frais.tarifs.index')
            ->with('success', 'Tarif scolaire ajouté avec succès.');
    }

    /**
     * Afficher les détails d'un tarif.
     */
    public function show(string $id)
    {
        $this->verifierPermission('frais.tarifs_voir');

        $tarif = TarifFrais::with([
            'typeFrais',
            'anneeScolaire',
            'classe',
            'elevesFrais',
        ])->findOrFail($id);

        return view('frais.tarifs.show', compact('tarif'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(string $id)
    {
        $this->verifierPermission('frais.tarifs_gerer');

        $tarif = TarifFrais::findOrFail($id);

        $types = TypeFrais::orderBy('nom')->get();

        $annees = AnneeScolaire::orderByDesc('date_debut')
            ->get();

        $classes = Classe::orderBy('nom')
            ->get();

        return view('frais.tarifs.edit', compact(
            'tarif',
            'types',
            'annees',
            'classes'
        ));
    }

    /**
     * Modifier un tarif scolaire.
     */
    public function update(Request $request, string $id)
    {
        $this->verifierPermission('frais.tarifs_gerer');

        $tarif = TarifFrais::findOrFail($id);

        $validated = $request->validate([
            'type_frais_id'     => [
                'required',
                'exists:types_frais,id',
            ],
            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],
            'classe_id'         => [
                'required',
                'exists:classes,id',
            ],
            'montant'           => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'date_debut'        => [
                'nullable',
                'date',
            ],
            'date_fin'          => [
                'nullable',
                'date',
                'after_or_equal:date_debut',
            ],
            'actif'             => [
                'nullable',
                'boolean',
            ],
        ], [
            'type_frais_id.required'     => 'Veuillez sélectionner un type de frais.',
            'annee_scolaire_id.required' => 'Veuillez sélectionner une année scolaire.',
            'classe_id.required'         => 'Veuillez sélectionner une classe.',
            'montant.required'           => 'Le montant du tarif est obligatoire.',
            'montant.numeric'            => 'Le montant doit être un nombre valide.',
            'montant.min'                => 'Le montant doit être supérieur à zéro.',
            'date_fin.after_or_equal'    => 'La date de fin doit être postérieure ou égale à la date de début.',
        ]);

        // Vérifier les doublons en excluant le tarif actuel.
        $existe = TarifFrais::where('type_frais_id', $validated['type_frais_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->where('classe_id', $validated['classe_id'])
            ->where('id', '!=', $tarif->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'type_frais_id' => 'Un autre tarif existe déjà pour ce type de frais, cette année scolaire et cette classe.',
                ]);
        }

        $validated['actif'] = $request->boolean('actif');

        $tarif->update($validated);

        return redirect()
            ->route('frais.tarifs.index')
            ->with('success', 'Tarif scolaire modifié avec succès.');
    }

    /**
     * Supprimer un tarif scolaire.
     */
    public function destroy(string $id)
    {
        $this->verifierPermission('frais.tarifs_gerer');

        $tarif = TarifFrais::findOrFail($id);

        // Protéger les frais déjà générés pour les élèves.
        if ($tarif->elevesFrais()->exists()) {
            return redirect()
                ->route('frais.tarifs.index')
                ->with(
                    'error',
                    'Impossible de supprimer ce tarif : il est déjà associé à des frais d’élèves.'
                );
        }

        $tarif->delete();

        return redirect()
            ->route('frais.tarifs.index')
            ->with('success', 'Tarif scolaire supprimé avec succès.');
    }
}