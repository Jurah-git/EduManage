<?php
namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalleController extends Controller
{
    public function index(Request $request)
    {
        $query = Salle::query();

        if ($request->filled('recherche')) {
            $recherche = $request->recherche;

            $query->where(function ($q) use ($recherche) {
                $q->where('code', 'like', "%{$recherche}%")
                    ->orWhere('nom', 'like', "%{$recherche}%")
                    ->orWhere('batiment', 'like', "%{$recherche}%")
                    ->orWhere('type', 'like', "%{$recherche}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $salles = $query->latest()->paginate(10)->withQueryString();

        return view('salles.index', compact('salles'));
    }

    public function create()
    {
        return view('salles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'         => ['required', 'string', 'max:255'],
            'batiment'    => ['nullable', 'string', 'max:255'],
            'etage'       => ['nullable', 'string', 'max:100'],
            'capacite'    => ['required', 'integer', 'min:1', 'max:10000'],
            'type'        => [
                'required',
                Rule::in(['Ordinaire', 'Laboratoire', 'Informatique', 'Autre']),
            ],
            'statut'      => [
                'required',
                Rule::in(['Disponible', 'Maintenance', 'Indisponible']),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $salle = Salle::create($validated);

        return redirect()
            ->route('salles.show', $salle)
            ->with('success', 'Salle créée avec succès. Code : ' . $salle->code);
    }

    public function show(Salle $salle)
    {
        return view('salles.show', compact('salle'));
    }

    public function edit(Salle $salle)
    {
        return view('salles.edit', compact('salle'));
    }

    public function update(Request $request, Salle $salle)
    {
        $validated = $request->validate([
            'nom'         => ['required', 'string', 'max:255'],
            'batiment'    => ['nullable', 'string', 'max:255'],
            'etage'       => ['nullable', 'string', 'max:100'],
            'capacite'    => ['required', 'integer', 'min:1', 'max:10000'],
            'type'        => [
                'required',
                Rule::in(['Ordinaire', 'Laboratoire', 'Informatique', 'Autre']),
            ],
            'statut'      => [
                'required',
                Rule::in(['Disponible', 'Maintenance', 'Indisponible']),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $salle->update($validated);

        return redirect()
            ->route('salles.show', $salle)
            ->with('success', 'Salle modifiée avec succès.');
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();

        return redirect()
            ->route('salles.index')
            ->with('success', 'Salle supprimée avec succès.');
    }
}
