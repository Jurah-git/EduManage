<?php
namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES INSCRIPTIONS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Inscription::with([
            'eleve',
            'classe',
            'anneeScolaire',
        ]);

        // Recherche par nom, prénom ou matricule
        if ($request->filled('recherche')) {
            $recherche = $request->recherche;

            $query->whereHas('eleve', function ($q) use ($recherche) {
                $q->where('nom', 'like', "%{$recherche}%")
                    ->orWhere('prenom', 'like', "%{$recherche}%")
                    ->orWhere('matricule', 'like', "%{$recherche}%");
            });
        }

        // Filtre par année scolaire
        if ($request->filled('annee_scolaire_id')) {
            $query->where(
                'annee_scolaire_id',
                $request->annee_scolaire_id
            );
        }

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $inscriptions = $query
            ->latest('date_inscription')
            ->paginate(10)
            ->withQueryString();

// =====================================================
// STATISTIQUES GLOBALES (indépendantes des filtres)
// =====================================================

        $totalInscriptions = Inscription::count();

        $totalValidees = Inscription::where('statut', 'validee')
            ->count();

        $totalEnAttente = Inscription::where('statut', 'en_attente')
            ->count();

        $totalFrais = Inscription::sum('frais_inscription');

        $anneesScolaires = AnneeScolaire::orderBy('date_debut', 'desc')->get();

        $classes = Classe::orderBy('nom')->get();

        return view('inscriptions.index', compact(
            'inscriptions',
            'anneesScolaires',
            'classes',
            'totalInscriptions',
            'totalValidees',
            'totalEnAttente',
            'totalFrais'
        ));
    }

    /*
|--------------------------------------------------------------------------
| FORMULAIRE NOUVELLE INSCRIPTION
|--------------------------------------------------------------------------
*/

    public function create()
    {
        $eleves = Eleve::orderBy('nom')
            ->orderBy('prenom')
            ->get();

        $classes = Classe::orderBy('nom')->get();

        // Élèves ayant déjà un historique d'inscription
        $elevesAvecHistorique = Inscription::pluck('eleve_id')
            ->unique()
            ->values()
            ->toArray();

        $anneeScolaire = AnneeScolaire::where('active', true)
            ->first();

        return view('inscriptions.create', compact(
            'eleves',
            'classes',
            'anneeScolaire',
            'elevesAvecHistorique'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UNE INSCRIPTION
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id'          => 'required|exists:eleves,id',
            'classe_id'         => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date_inscription'  => 'required|date',
            'type'              => 'nullable|in:nouvelle_inscription,reinscription',
            'frais_inscription' => 'nullable|numeric|min:0',
            'observations'      => 'nullable|string|max:5000',
        ]);

        // Vérifier qu'une année scolaire active existe
        $anneeActive = AnneeScolaire::where('active', true)->first();

        if (! $anneeActive) {
            return back()
                ->withInput()
                ->withErrors([
                    'annee_scolaire_id' => 'Aucune année scolaire active n’est configurée.',
                ]);
        }

        // Vérifier que l'inscription concerne bien l'année active
        if ((int) $validated['annee_scolaire_id'] !== (int) $anneeActive->id) {
            return back()
                ->withInput()
                ->withErrors([
                    'annee_scolaire_id' => 'L’inscription doit être effectuée pour l’année scolaire active.',
                ]);
        }

        // Vérifier si l'élève est déjà inscrit pour cette année
        $existe = Inscription::where('eleve_id', $validated['eleve_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'eleve_id' => 'Cet élève possède déjà une inscription pour cette année scolaire.',
                ]);
        }

        // Déterminer automatiquement le type d'inscription
        $dejaInscrit = Inscription::where('eleve_id', $validated['eleve_id'])
            ->exists();

        $typeAutomatique = $dejaInscrit
            ? 'reinscription'
            : 'nouvelle_inscription';

        // Enregistrer l'inscription
        Inscription::create([
            'eleve_id'          => $validated['eleve_id'],
            'classe_id'         => $validated['classe_id'],
            'annee_scolaire_id' => $validated['annee_scolaire_id'],
            'date_inscription'  => $validated['date_inscription'],
            'type'              => $typeAutomatique,
            'statut'            => 'en_attente',
            'frais_inscription' => $validated['frais_inscription'] ?? 0,
            'observations'      => $validated['observations'] ?? null,
        ]);

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription enregistrée avec succès.');
    }

    /*
|--------------------------------------------------------------------------
| DÉTAIL D'UNE INSCRIPTION
|--------------------------------------------------------------------------
*/

    public function show(Inscription $inscription)
    {
        $inscription->load([
            'eleve',
            'classe',
            'anneeScolaire',
        ]);

        return view('inscriptions.show', compact('inscription'));
    }

    /*
|--------------------------------------------------------------------------
| FORMULAIRE MODIFICATION INSCRIPTION
|--------------------------------------------------------------------------
*/

    public function edit(Inscription $inscription)
    {
        $inscription->load([
            'eleve',
            'classe',
            'anneeScolaire',
        ]);

        $eleves = Eleve::orderBy('nom')
            ->orderBy('prenom')
            ->get();

        $classes = Classe::orderBy('nom')->get();

        // Élèves ayant déjà un historique d'inscription
        $elevesAvecHistorique = Inscription::where('id', '!=', $inscription->id)
            ->pluck('eleve_id')
            ->unique()
            ->values()
            ->toArray();

        $anneesScolaires = AnneeScolaire::orderBy('date_debut', 'desc')
            ->get();

        return view('inscriptions.edit', compact(
            'inscription',
            'eleves',
            'classes',
            'anneesScolaires',
            'elevesAvecHistorique'
        ));
    }

    /*
|--------------------------------------------------------------------------
| METTRE À JOUR UNE INSCRIPTION
|--------------------------------------------------------------------------
*/

    public function update(Request $request, Inscription $inscription)
    {
        $validated = $request->validate([
            'eleve_id'          => 'required|exists:eleves,id',
            'classe_id'         => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date_inscription'  => 'required|date',
            'type'              => 'nullable|in:nouvelle_inscription,reinscription',
            'statut'            => 'required|in:en_attente,validee,annulee',
            'frais_inscription' => 'nullable|numeric|min:0',
            'observations'      => 'nullable|string|max:5000',
        ]);

        // Vérifier qu'une année scolaire active existe
        $anneeActive = AnneeScolaire::where('active', true)->first();

        if (! $anneeActive) {
            return back()
                ->withInput()
                ->withErrors([
                    'annee_scolaire_id' => 'Aucune année scolaire active n’est configurée.',
                ]);
        }

        // Vérifier que la modification concerne l'année active
        if ((int) $validated['annee_scolaire_id'] !== (int) $anneeActive->id) {
            return back()
                ->withInput()
                ->withErrors([
                    'annee_scolaire_id' => 'La modification doit concerner l’année scolaire active.',
                ]);
        }

        // Vérifier les doublons pour un même élève et une même année
        $existe = Inscription::where('eleve_id', $validated['eleve_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->where('id', '!=', $inscription->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'eleve_id' => 'Cet élève possède déjà une inscription pour cette année scolaire.',
                ]);
        }

        // Déterminer le type selon l'historique de l'élève
        // On exclut l'inscription actuellement modifiée
        $dejaInscrit = Inscription::where('eleve_id', $validated['eleve_id'])
            ->where('id', '!=', $inscription->id)
            ->exists();

        $typeAutomatique = $dejaInscrit
            ? 'reinscription'
            : 'nouvelle_inscription';

        $inscription->update([
            'eleve_id'          => $validated['eleve_id'],
            'classe_id'         => $validated['classe_id'],
            'annee_scolaire_id' => $validated['annee_scolaire_id'],
            'date_inscription'  => $validated['date_inscription'],
            'type'              => $typeAutomatique,
            'statut'            => $validated['statut'],
            'frais_inscription' => $validated['frais_inscription'] ?? 0,
            'observations'      => $validated['observations'] ?? null,
        ]);

        return redirect()
            ->route('inscriptions.show', $inscription->id)
            ->with('success', 'Inscription mise à jour avec succès.');
    }

    /*
|--------------------------------------------------------------------------
| SUPPRIMER UNE INSCRIPTION
|--------------------------------------------------------------------------
*/

    public function destroy(Inscription $inscription)
    {
        // Empêcher la suppression d'une inscription validée
        if ($inscription->statut === 'validee') {
            return redirect()
                ->route('inscriptions.index')
                ->with('error', 'Impossible de supprimer une inscription validée.');
        }

        $inscription->delete();

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }
}