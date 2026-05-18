<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Periode;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    // =========================
    // PAGE SAISIE
    // =========================
    public function saisie()
    {
        $eleves = Eleve::with('classe')->get();

        $periodes = Periode::all();

        return view(
            'bulletin.saisie',
            compact(
                'eleves',
                'periodes'
            )
        );
    }

    // =========================
    // CHARGER ELEVE + MATIERES (AJAX)
    // =========================
    public function getEleve($id)
    {
        $eleve = Eleve::with(
            'classe.matieres'
        )->findOrFail($id);

        $periodes = Periode::all();

        $notes = Note::where(
            'eleve_id',
            $id
        )

            ->get()

            ->groupBy(function ($n) {

                return
                    $n->type . '_' .
                    $n->matiere_id;
            });

        return view(
            'bulletin.partials.notes_form',
            [

                'eleve' => $eleve,

                'matieres' =>
                $eleve
                    ->classe
                    ->matieres,

                'periodes' =>
                $periodes,

                'notes' =>
                $notes

            ]
        );
    }
    // =========================
    // ENREGISTRER NOTES
    // =========================
    public function store(Request $request)
    {
        $request->validate([

            'eleve_id' => 'required',

            'type' => 'required',

            'periode_id' => 'required',

            'notes' => 'required|array'

        ]);

        foreach ($request->notes as $matiere_id => $data) {

            Note::updateOrCreate(

                [

                    'eleve_id' => $request->eleve_id,

                    'matiere_id' => $matiere_id,

                    'type' => $request->type,

                    'periode_id' => $request->periode_id

                ],

                [

                    'valeur' => $data['valeur'] ?? 0,

                    'coef' => $data['coef'] ?? 1,

                    'base' => $data['base'] ?? 20

                ]

            );
        }

        return response()->json([

            'success' => true,

            'message' => 'Notes enregistrées'

        ]);
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        return view('bulletin.index');
    }

    public function validation()
    {
        return view('bulletin.validation');
    }

    public function generer()
    {
        return view('bulletin.generer');
    }
}
