<?php
namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\EmploiTemps;
use Illuminate\Http\Request;

class EmploiTempsController extends Controller
{
    public function index(Request $request)
    {
        $query = EmploiTemps::with(['classe', 'anneeScolaire'])
            ->withCount('creneaux');

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->filled('annee_scolaire_id')) {
            $query->where(
                'annee_scolaire_id',
                $request->annee_scolaire_id
            );
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $emploisTemps = $query->latest()->paginate(10)->withQueryString();

        $classes         = Classe::orderBy('id')->get();
        $anneesScolaires = AnneeScolaire::orderByDesc('id')->get();

        return view('emplois_temps.index', compact(
            'emploisTemps',
            'classes',
            'anneesScolaires'
        ));
    }

    public function create()
    {
        $classes         = Classe::orderBy('id')->get();
        $anneesScolaires = AnneeScolaire::orderByDesc('id')->get();

        return view('emplois_temps.create', compact(
            'classes',
            'anneesScolaires'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id'         => ['required', 'exists:classes,id'],
            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],
            'titre'             => ['nullable', 'string', 'max:255'],
        ]);

        $existe = EmploiTemps::where(
            'classe_id',
            $validated['classe_id']
        )->where(
            'annee_scolaire_id',
            $validated['annee_scolaire_id']
        )->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'classe_id' =>
                    'Un emploi du temps existe déjà pour cette classe et cette année scolaire.',
                ]);
        }

        $emploiTemps = EmploiTemps::create([
             ...$validated,
            'statut' => 'brouillon',
        ]);

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with('success', 'Emploi du temps créé avec succès.');
    }


public function show(EmploiTemps $emploiTemps)
{
    // Charger les relations de l'emploi du temps.
    $emploiTemps->load([
        'classe',
        'anneeScolaire',
        'creneaux.matiere',
        'creneaux.enseignant',
        'creneaux.salle',
    ]);

    // Récupérer les matières associées à la classe.
    $matieres = \App\Models\Matiere::whereHas(
        'classes',
        function ($query) use ($emploiTemps) {
            $query->where('classes.id', $emploiTemps->classe_id);
        }
    )->orderBy('nom')->get();

    // Récupérer les enseignants.
    $enseignants = \App\Models\Enseignant::orderBy('nom')->get();

    // Récupérer les salles.
    $salles = \App\Models\Salle::orderBy('nom')->get();

    // Envoyer toutes les données à la vue.
    return view('emplois_temps.show', compact(
        'emploiTemps',
        'matieres',
        'enseignants',
        'salles'
    ));
}



    public function edit(EmploiTemps $emploiTemps)
    {
        if ($emploiTemps->statut === 'publie') {
            return redirect()
                ->route('emplois-temps.show', $emploiTemps)
                ->with('error', 'Un emploi du temps publié ne peut pas être modifié.');
        }

        $classes         = Classe::orderBy('id')->get();
        $anneesScolaires = AnneeScolaire::orderByDesc('id')->get();

        return view('emplois_temps.edit', compact(
            'emploiTemps',
            'classes',
            'anneesScolaires'
        ));
    }

    public function update(Request $request, EmploiTemps $emploiTemps)
    {
        if ($emploiTemps->statut === 'publie') {
            return redirect()
                ->route('emplois-temps.show', $emploiTemps)
                ->with('error', 'Un emploi du temps publié ne peut pas être modifié.');
        }

        $validated = $request->validate([
            'classe_id'         => ['required', 'exists:classes,id'],
            'annee_scolaire_id' => [
                'required',
                'exists:annee_scolaires,id',
            ],
            'titre'             => ['nullable', 'string', 'max:255'],
        ]);

        $existe = EmploiTemps::where(
            'classe_id',
            $validated['classe_id']
        )->where(
            'annee_scolaire_id',
            $validated['annee_scolaire_id']
        )->where('id', '!=', $emploiTemps->id)->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'classe_id' =>
                    'Un emploi du temps existe déjà pour cette classe et cette année scolaire.',
                ]);
        }

        $emploiTemps->update($validated);

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with('success', 'Emploi du temps modifié avec succès.');
    }

    public function destroy(EmploiTemps $emploiTemps)
    {
        if ($emploiTemps->statut === 'publie') {
            return back()->with(
                'error',
                'Un emploi du temps publié ne peut pas être supprimé.'
            );
        }

        $emploiTemps->delete();

        return redirect()
            ->route('emplois-temps.index')
            ->with('success', 'Emploi du temps supprimé avec succès.');
    }

    public function publier(EmploiTemps $emploiTemps)
    {
        if (! $emploiTemps->creneaux()->exists()) {
            return back()->with(
                'error',
                'Ajoute au moins un créneau avant de publier cet emploi du temps.'
            );
        }

        $emploiTemps->update(['statut' => 'publie']);

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with('success', 'Emploi du temps publié avec succès.');
    }

    public function brouillon(EmploiTemps $emploiTemps)
    {
        $emploiTemps->update(['statut' => 'brouillon']);

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with('success', 'Emploi du temps remis en brouillon.');
    }
}