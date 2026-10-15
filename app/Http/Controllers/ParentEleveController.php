<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\ParentEleve;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParentEleveController extends Controller
{
    public function index()
    {
        $parents = ParentEleve::withCount('eleves')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(10);

        return view('parents.index', compact('parents'));
    }

    public function create()
    {
        $eleves = Eleve::orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('parents.create', compact('eleves'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'                        => ['required', 'string', 'max:255'],
            'prenom'                     => ['required', 'string', 'max:255'],
            'telephone'                  => ['nullable', 'string', 'max:30'],
            'telephone_secondaire'       => ['nullable', 'string', 'max:30'],
            'email'                      => ['nullable', 'email', 'max:255'],
            'profession'                 => ['nullable', 'string', 'max:255'],
            'adresse'                    => ['nullable', 'string', 'max:2000'],
            'eleves'                     => ['nullable', 'array'],
            'eleves.*.id'                => [
                'required',
                'integer',
                'distinct',
                'exists:eleves,id',
            ],
            'eleves.*.lien_parente'      => [
                'required',
                Rule::in(['Père', 'Mère', 'Tuteur', 'Autre']),
            ],
            'eleves.*.responsable_legal' => ['nullable', 'boolean'],
            'eleves.*.contact_principal' => ['nullable', 'boolean'],
        ]);

        $parent = ParentEleve::create([
            'nom'                  => $validated['nom'],
            'prenom'               => $validated['prenom'],
            'telephone'            => $validated['telephone'] ?? null,
            'telephone_secondaire' => $validated['telephone_secondaire'] ?? null,
            'email'                => $validated['email'] ?? null,
            'profession'           => $validated['profession'] ?? null,
            'adresse'              => $validated['adresse'] ?? null,
        ]);

        $this->synchroniserEleves($parent, $validated['eleves'] ?? []);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Le parent a été enregistré avec succès.');
    }

    public function show(ParentEleve $parent)
    {
        $parent->load('eleves');

        return view('parents.show', compact('parent'));
    }

    public function edit(ParentEleve $parent)
    {
        $parent->load('eleves');

        $eleves = Eleve::orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('parents.edit', compact('parent', 'eleves'));
    }

    public function update(Request $request, ParentEleve $parent)
    {
        $validated = $request->validate([
            'nom'                        => ['required', 'string', 'max:255'],
            'prenom'                     => ['required', 'string', 'max:255'],
            'telephone'                  => ['nullable', 'string', 'max:30'],
            'telephone_secondaire'       => ['nullable', 'string', 'max:30'],
            'email'                      => ['nullable', 'email', 'max:255'],
            'profession'                 => ['nullable', 'string', 'max:255'],
            'adresse'                    => ['nullable', 'string', 'max:2000'],
            'eleves'                     => ['nullable', 'array'],
            'eleves.*.id'                => [
                'required',
                'integer',
                'distinct',
                'exists:eleves,id',
            ],
            'eleves.*.lien_parente'      => [
                'required',
                Rule::in(['Père', 'Mère', 'Tuteur', 'Autre']),
            ],
            'eleves.*.responsable_legal' => ['nullable', 'boolean'],
            'eleves.*.contact_principal' => ['nullable', 'boolean'],
        ]);

        $parent->update([
            'nom'                  => $validated['nom'],
            'prenom'               => $validated['prenom'],
            'telephone'            => $validated['telephone'] ?? null,
            'telephone_secondaire' => $validated['telephone_secondaire'] ?? null,
            'email'                => $validated['email'] ?? null,
            'profession'           => $validated['profession'] ?? null,
            'adresse'              => $validated['adresse'] ?? null,
        ]);

        $this->synchroniserEleves($parent, $validated['eleves'] ?? []);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Les informations du parent ont été mises à jour.');
    }

    public function destroy(ParentEleve $parent)
    {
        // Supprime la fiche parent et ses associations,
        // sans supprimer les élèves ni leur fiche.
        $parent->delete();

        return redirect()
            ->route('parents.index')
            ->with('success', 'Le parent a été supprimé.');
    }

    private function synchroniserEleves(
        ParentEleve $parent,
        array $eleves
    ): void {
        $associations = [];

        foreach ($eleves as $eleve) {
            $associations[$eleve['id']] = [
                'lien_parente'      => $eleve['lien_parente'],
                'responsable_legal' =>
                ! empty($eleve['responsable_legal']),
                'contact_principal' =>
                ! empty($eleve['contact_principal']),
            ];
        }

        $parent->eleves()->sync($associations);
    }
}