<?php
namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\ClasseMatiereCoefficient;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $eleve = Eleve::with('classe.matieres')->findOrFail($id);

        $periodes = Periode::all();

        // Récupérer toutes les notes de cet élève
        // et les organiser :
        //
        // $notes[periode_id][type][matiere_id]
        //
        $notes = Note::where('eleve_id', $id)
            ->get()
            ->groupBy('periode_id')
            ->map(function ($notesPeriode) {

                return $notesPeriode
                    ->groupBy('type')
                    ->map(function ($notesType) {

                        return $notesType->keyBy('matiere_id');

                    });

            });

        // Récupérer les coefficients de la classe
        $coefficients = ClasseMatiereCoefficient::where(
            'classe_id',
            $eleve->classe_id
        )
            ->pluck('coef', 'matiere_id')
            ->toArray();

        return view(
            'bulletin.partials.notes_form',
            [
                'eleve'        => $eleve,

                'matieres'     => $eleve
                    ->classe
                    ->matieres,

                'periodes'     => $periodes,

                'notes'        => $notes,

                'coefficients' => $coefficients,
            ]
        );
    }

    // =========================
    // ENREGISTRER NOTES
    // =========================
    public function store(Request $request)
    {
        $request->validate([

            'eleve_id'   => 'required',

            'type'       => 'required',

            'periode_id' => 'required',

            'notes'      => 'required|array',

        ]);

        foreach ($request->notes as $matiere_id => $data) {

            Note::updateOrCreate(

                [

                    'eleve_id'   => $request->eleve_id,

                    'matiere_id' => $matiere_id,

                    'type'       => $request->type,

                    'periode_id' => $request->periode_id,

                ],

                [

                    'valeur' => $data['valeur'] ?? 0,

                    'coef'   => $data['coef'] ?? 1,

                    'base'   => $data['base'] ?? 20,

                ]

            );
        }

        return response()->json([

            'success' => true,

            'message' => 'Notes enregistrées',

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

    public function verifierPeriodes(
        Request $request
    ) {

        $eleve_id =
        $request->eleve_id;

        foreach (

            $request->periodes as

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
                ! $existe
            ) {

                return response()

                    ->json([

                        'success' => false,

                        'periode' => $periode_id,

                    ]);
            }
        }

        return response()

            ->json([

                'success' => true,
            ]);
    }

    public function afficherBulletin(
        Request $request
    ) {$request->validate([
        'eleve_id' => 'required',
        'periodes' => 'required|array|min:1',
    ]);
        $eleve = Eleve::with(
            'classe'
        )

            ->findOrFail(

                $request->eleve_id

            );

        $bulletins = [];

        foreach (

            $request->periodes as

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

                'notes'   => $notes,

                'moyenne' => $moyenne,

            ];
        }

        return view(

            'bulletin.affichage',

            compact(

                'eleve',

                'bulletins'

            )

        );}

    // =========================
    // SAVE IMAGE BASE 64
    // =========================
    public function saveImage(Request $request)
    {
        try {

            $bulletin = Bulletin::create([
                'eleve_id'     => $request->eleve_id,
                'image_base64' => $request->image,
                'periodes_ids' => $request->periodes_ids,
            ]);

            return response()->json([
                'ok' => true,
                'id' => $bulletin->id,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'ok'      => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function voirImage($id)
    {
        $bulletin = Bulletin::findOrFail($id);

        return view(
            'bulletin.voir',
            compact('bulletin')
        );
    }

    public function downloadImage($id)
    {
        $bulletin = Bulletin::findOrFail($id);

        $image = str_replace(
            'data:image/png;base64,',
            '',
            $bulletin->image_base64
        );

        return response(
            base64_decode($image)
        )
            ->header(
                'Content-Type',
                'image/png'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename=bulletin_' . $id . '.png'
            );
    }

    public function printImage($id)
    {
        $bulletin = Bulletin::findOrFail($id);

        return view(
            'bulletin.print',
            compact('bulletin')
        );
    }

    public function generer()
    {
        $eleves = Eleve::with('classe')->get();

        $periodes = Periode::all();

        return view(
            'bulletin.generer',
            compact(
                'eleves',
                'periodes'
            )
        );
    }
    public function voirDirect(Request $request)
    {
        $bulletin = Bulletin::where(
            'eleve_id',
            $request->eleve_id
        )
            ->where(
                'periodes_ids',
                $request->periodes
            )
            ->latest()
            ->first();

        if (! $bulletin) {

            return back()->with(
                'error',
                'Aucun bulletin enregistré pour ces périodes.'
            );
        }

        return view(
            'bulletin.voir',
            compact('bulletin')
        );
    }

    public function downloadDirect(Request $request)
    {
        $bulletin = Bulletin::where(
            'eleve_id',
            $request->eleve_id
        )
            ->where(
                'periodes_ids',
                $request->periodes
            )
            ->latest()
            ->firstOrFail();

        $image = str_replace(
            'data:image/png;base64,',
            '',
            $bulletin->image_base64
        );

        return response(
            base64_decode($image)
        )
            ->header('Content-Type', 'image/png')
            ->header(
                'Content-Disposition',
                'attachment; filename=bulletin.png'
            );
    }

    public function printDirect(Request $request)
    {
        $bulletin = Bulletin::where(
            'eleve_id',
            $request->eleve_id
        )
            ->where(
                'periodes_ids',
                $request->periodes
            )
            ->latest()
            ->firstOrFail();

        return view(
            'bulletin.print',
            compact('bulletin')
        );
    }

    public function downloadDirectPng(Request $request)
    {
        $bulletin = Bulletin::where(
            'eleve_id',
            $request->eleve_id
        )
            ->where(
                'periodes_ids',
                $request->periodes
            )
            ->latest()
            ->firstOrFail();

        $image = str_replace(
            'data:image/png;base64,',
            '',
            $bulletin->image_base64
        );

        return response(
            base64_decode($image)
        )
            ->header(
                'Content-Type',
                'image/png'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename=bulletin.png'
            );
    }

    public function downloadDirectPdf(Request $request)
    {
        $bulletin = Bulletin::where(
            'eleve_id',
            $request->eleve_id
        )
            ->where(
                'periodes_ids',
                $request->periodes
            )
            ->latest()
            ->firstOrFail();

        $pdf = Pdf::loadView(
            'bulletin.pdf',
            compact('bulletin')
        );

        return $pdf->download(
            'bulletin.pdf'
        );
    }
}
