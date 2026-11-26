<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RangMatiereController extends Controller
{
    /**
     * Afficher les classes et les matières d'une classe sélectionnée.
     */
    public function index(Request $request)
    {
        $classes = Classe::orderBy('nom')->get();

        $classeSelectionnee = null;

        if ($request->filled('classe_id')) {
            $classeSelectionnee = Classe::with('matieres')
                ->findOrFail($request->classe_id);
        }

        return view('config.rang_matiere', compact(
            'classes',
            'classeSelectionnee'
        ));
    }

    /**
     * Modifier l'ordre de deux matières dans une classe.
     */
    public function deplacer(Request $request)
    {
        $request->validate([
            'classe_id'  => 'required|integer|exists:classes,id',
            'matiere_id' => 'required|integer|exists:matieres,id',
            'direction'  => 'required|in:haut,bas',
        ]);

        $classe = Classe::with('matieres')->findOrFail(
            $request->classe_id
        );

        $matieres = $classe->matieres->values();

        $index = $matieres->search(
            fn($matiere) => (int) $matiere->id === (int) $request->matiere_id
        );

        if ($index === false) {
            return back()->with('error', 'Cette matière n’appartient pas à cette classe.');
        }

        $nouvelIndex = $request->direction === 'haut'
            ? $index - 1
            : $index + 1;

        if (! $matieres->has($nouvelIndex)) {
            return back()->with('info', 'Cette matière ne peut pas être déplacée davantage.');
        }

        $matiereActuelle = $matieres[$index];
        $matiereVoisine  = $matieres[$nouvelIndex];

        DB::transaction(function () use ($classe, $matiereActuelle, $matiereVoisine) {

            $ordreActuel = (int) $matiereActuelle->pivot->ordre;
            $ordreVoisin = (int) $matiereVoisine->pivot->ordre;

            // Valeur temporaire positive pour éviter les conflits
            $ordreTemporaire = (int) DB::table('classe_matiere')
                ->where('classe_id', $classe->id)
                ->max('ordre') + 1;

            DB::table('classe_matiere')
                ->where('classe_id', $classe->id)
                ->where('matiere_id', $matiereActuelle->id)
                ->update(['ordre' => $ordreTemporaire]);

            DB::table('classe_matiere')
                ->where('classe_id', $classe->id)
                ->where('matiere_id', $matiereVoisine->id)
                ->update(['ordre' => $ordreActuel]);

            DB::table('classe_matiere')
                ->where('classe_id', $classe->id)
                ->where('matiere_id', $matiereActuelle->id)
                ->update(['ordre' => $ordreVoisin]);
        });

        return redirect()
            ->route('config.rang_matiere', ['classe_id' => $classe->id])
            ->with('success', 'Ordre des matières modifié avec succès.');
    }
    public function enregistrer(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|integer|exists:classes,id',
            'ordre'     => 'required|array|min:1',
            'ordre.*'   => 'required|integer|distinct|exists:matieres,id',
        ]);

        $classeId    = $request->classe_id;
        $nouvelOrdre = $request->ordre;

        // Vérifier que les matières envoyées correspondent exactement
        // aux matières associées à cette classe.
        $matieresClasse = DB::table('classe_matiere')
            ->where('classe_id', $classeId)
            ->pluck('matiere_id')
            ->map(fn($id) => (int) $id)
            ->sort()
            ->values()
            ->all();

        $matieresEnvoyees = collect($nouvelOrdre)
            ->map(fn($id) => (int) $id)
            ->sort()
            ->values()
            ->all();

        if ($matieresClasse !== $matieresEnvoyees) {
            return back()->with('error', 'La liste des matières est invalide.');
        }

        DB::transaction(function () use ($classeId, $nouvelOrdre) {
            foreach ($nouvelOrdre as $index => $matiereId) {
                DB::table('classe_matiere')
                    ->where('classe_id', $classeId)
                    ->where('matiere_id', $matiereId)
                    ->update([
                        'ordre' => $index + 1,
                    ]);
            }
        });

        return redirect()
            ->route('config.rang_matiere', ['classe_id' => $classeId])
            ->with('success', 'Le nouvel ordre des matières a été enregistré.');
    }
}