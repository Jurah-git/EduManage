<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\ClasseMatiereCoefficient;

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
                    $n->type .
                    '_' .
                    $n->matiere_id;
            });

        $coefficients = ClasseMatiereCoefficient::where(
            'classe_id',
            $eleve->classe_id
        )

            ->pluck(
                'coef',
                'matiere_id'
            )

            ->toArray();

        return view(

            'bulletin.partials.notes_form',

            [

                'eleve' => $eleve,

                'matieres' =>

                $eleve
                    ->classe
                    ->matieres,

                'periodes' => $periodes,

                'notes' => $notes,

                'coefficients' =>
                $coefficients

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

        $eleves = Eleve::with(
            'classe'
        )->get();

        return view(

            'bulletin.generer',

            compact(
                'eleves'
            )

        );
    }

    public function choixPeriode($id)
    {

        $eleve = Eleve::findOrFail(
            $id
        );

        $periodes = Periode::all();

        return view(

            'bulletin.choix',

            compact(

                'eleve',

                'periodes'

            )

        );
    }

    public function verifierPeriodes(
        Request $request
    ) {

        $eleve_id =
            $request->eleve_id;

        foreach (

            $request->periodes

            as

            $periode_id

        ) {

            $existe = Note::where(

                'eleve_id',

                $eleve_id

            )

                ->where(

                    'periode_id',

                    $periode_id

                )

                ->exists();

            if (
                !$existe
            ) {

                return response()

                    ->json([

                        'success' => false,

                        'periode' => $periode_id

                    ]);
            }
        }

        return response()

            ->json([

                'success' => true
            ]);
    }

    public function afficherBulletin(
        Request $request
    ) {

        $eleve = Eleve::with(
            'classe'
        )

            ->findOrFail(

                $request->eleve_id

            );

        $bulletins = [];

        foreach (

            $request->periodes

            as

            $periode_id

        ) {

            $periode = Periode::find(
                $periode_id
            );

            $notes = Note::where(

                'eleve_id',

                $eleve->id

            )

                ->where(

                    'periode_id',

                    $periode_id

                )

                ->with(
                    'matiere'
                )

                ->get();

            $total =

                $notes->sum(
                    'valeur'
                );

            $coef =

                $notes->sum(
                    'coef'
                );

            $moyenne =

                $coef > 0

                ?

                $total / $coef

                :

                0;

            $bulletins[] = [

                'periode' => $periode,

                'notes' => $notes,

                'moyenne' => $moyenne

            ];
        }

        return view(

            'bulletin.affichage',

            compact(

                'eleve',

                'bulletins'

            )

        );
    }
}
