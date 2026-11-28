<?php
namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\EmploiTemps;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploiTempsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES EMPLOIS DU TEMPS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.voir'), 403);

        $query = EmploiTemps::with(['classe', 'anneeScolaire'])
            ->withCount('creneaux');

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
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

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE CRÉATION
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.creer'), 403);

        $classes         = Classe::orderBy('id')->get();
        $anneesScolaires = AnneeScolaire::orderByDesc('id')->get();

        return view('emplois_temps.create', compact(
            'classes',
            'anneesScolaires'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UN EMPLOI DU TEMPS
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.creer'), 403);

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
                    'classe_id' => 'Un emploi du temps existe déjà pour cette classe et cette année scolaire.',
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

    /*
    |--------------------------------------------------------------------------
    | VOIR LES DÉTAILS
    |--------------------------------------------------------------------------
    */
    public function show(EmploiTemps $emploiTemps)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.show'), 403);

        $emploiTemps->load([
            'classe',
            'anneeScolaire',
            'creneaux.matiere',
            'creneaux.enseignant',
            'creneaux.salle',
        ]);

        $matieres = Matiere::whereHas(
            'classes',
            function ($query) use ($emploiTemps) {
                $query->where('classes.id', $emploiTemps->classe_id);
            }
        )->orderBy('nom')->get();

        $enseignants = Enseignant::orderBy('nom')->get();

        $salles = Salle::orderBy('nom')->get();

        return view('emplois_temps.show', compact(
            'emploiTemps',
            'matieres',
            'enseignants',
            'salles'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE MODIFICATION
    |--------------------------------------------------------------------------
    */
    public function edit(EmploiTemps $emploiTemps)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.modifier'), 403);

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

    /*
    |--------------------------------------------------------------------------
    | METTRE À JOUR
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, EmploiTemps $emploiTemps)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.modifier'), 403);

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
                    'classe_id' => 'Un emploi du temps existe déjà pour cette classe et cette année scolaire.',
                ]);
        }

        $emploiTemps->update($validated);

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with('success', 'Emploi du temps modifié avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER
    |--------------------------------------------------------------------------
    */
    public function destroy(EmploiTemps $emploiTemps)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.supprimer'), 403);

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

    /*
    |--------------------------------------------------------------------------
    | PUBLIER
    |--------------------------------------------------------------------------
    */
    public function publier(EmploiTemps $emploiTemps)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.valider'), 403);

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

    /*
    |--------------------------------------------------------------------------
    | REMETTRE EN BROUILLON
    |--------------------------------------------------------------------------
    */
    public function brouillon(EmploiTemps $emploiTemps)
    {
        abort_unless(auth()->user()->aPermission('emploi_temps.valider'), 403);

        $emploiTemps->update(['statut' => 'brouillon']);

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with('success', 'Emploi du temps remis en brouillon.');
    }
    /**
 * Consulter les emplois du temps publiés des enfants.
 */
public function emploiTemps(Request $request)
{
    $parent = $request->user()->parentEleve;

    abort_if(! $parent, 403);

    // Récupérer uniquement les enfants de ce parent.
    $eleves = $parent->eleves()
        ->with([
            'classe.emploisTemps' => function ($query) {
                $query->where('statut', 'publie')
                    ->with([
                        'anneeScolaire',
                        'creneaux.matiere',
                        'creneaux.enseignant',
                        'creneaux.salle',
                    ]);
            },
        ])
        ->orderBy('nom')
        ->orderBy('prenom')
        ->get();

    return view('parent.emploi-temps', compact('parent', 'eleves'));
}
}