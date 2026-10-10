<?php
namespace App\Http\Controllers;

use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EnseignantController extends Controller
{
    public function index(Request $request)
    {
        $recherche = $request->input('recherche');

        $enseignants = Enseignant::query()
            ->when($recherche, function ($query, $recherche) {
                $query->where(function ($q) use ($recherche) {
                    $q->where('matricule', 'like', "%{$recherche}%")
                        ->orWhere('nom', 'like', "%{$recherche}%")
                        ->orWhere('prenom', 'like', "%{$recherche}%")
                        ->orWhere('specialite', 'like', "%{$recherche}%")
                        ->orWhere('telephone', 'like', "%{$recherche}%");
                });
            })
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(10)
            ->withQueryString();

        return view('enseignants.index', compact('enseignants', 'recherche'));
    }

    public function create()
    {
        return view('enseignants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'              => ['required', 'string', 'max:100'],
            'prenom'           => ['required', 'string', 'max:100'],
            'sexe'             => ['nullable', Rule::in(['Masculin', 'Féminin'])],
            'date_naissance'   => ['nullable', 'date', 'before_or_equal:today'],
            'telephone'        => ['nullable', 'string', 'max:30'],
            'email'            => ['nullable', 'email', 'max:255', 'unique:enseignants,email'],
            'adresse'          => ['nullable', 'string', 'max:2000'],
            'diplome'          => ['nullable', 'string', 'max:255'],
            'specialite'       => ['nullable', 'string', 'max:255'],
            'date_recrutement' => ['nullable', 'date', 'before_or_equal:today'],
            'statut'           => ['required', Rule::in(['actif', 'inactif'])],
            'photo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nom.required'                     => 'Le nom est obligatoire.',
            'prenom.required'                  => 'Le prénom est obligatoire.',
            'date_naissance.before_or_equal'   => 'La date de naissance ne peut pas être dans le futur.',
            'date_recrutement.before_or_equal' => 'La date de recrutement ne peut pas être dans le futur.',
            'email.unique'                     => 'Cette adresse e-mail est déjà utilisée.',
            'photo.image'                      => 'Le fichier doit être une image.',
            'photo.max'                        => 'La photo ne doit pas dépasser 2 Mo.',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('enseignants', 'public');
        }

        $enseignant = Enseignant::create($validated);

        return redirect()
            ->route('enseignants.show', $enseignant)
            ->with('success', 'Enseignant ajouté avec succès. Matricule : ' . $enseignant->matricule);
    }

    public function show(Enseignant $enseignant)
    {
        return view('enseignants.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        return view('enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $validated = $request->validate([
            'nom'              => ['required', 'string', 'max:100'],
            'prenom'           => ['required', 'string', 'max:100'],
            'sexe'             => ['nullable', Rule::in(['Masculin', 'Féminin'])],
            'date_naissance'   => ['nullable', 'date', 'before_or_equal:today'],
            'telephone'        => ['nullable', 'string', 'max:30'],
            'email'            => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('enseignants', 'email')->ignore($enseignant->id),
            ],
            'adresse'          => ['nullable', 'string', 'max:2000'],
            'diplome'          => ['nullable', 'string', 'max:255'],
            'specialite'       => ['nullable', 'string', 'max:255'],
            'date_recrutement' => ['nullable', 'date', 'before_or_equal:today'],
            'statut'           => ['required', Rule::in(['actif', 'inactif'])],
            'photo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        unset($validated['matricule']);

        if ($request->hasFile('photo')) {
            if ($enseignant->photo) {
                Storage::disk('public')->delete($enseignant->photo);
            }

            $validated['photo'] = $request->file('photo')
                ->store('enseignants', 'public');
        }

        $enseignant->update($validated);

        return redirect()
            ->route('enseignants.show', $enseignant)
            ->with('success', 'Fiche de l’enseignant modifiée avec succès.');
    }

    public function destroy(Enseignant $enseignant)
    {
        if ($enseignant->photo) {
            Storage::disk('public')->delete($enseignant->photo);
        }

        $enseignant->delete();

        return redirect()
            ->route('enseignants.index')
            ->with('success', 'Enseignant supprimé avec succès.');
    }
}
