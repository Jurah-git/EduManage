<?php
namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\ClasseMatiereCoefficient;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulletinController extends Controller
{
    /**
     * Vérifier si l'utilisateur peut accéder au bulletin d'un élève.
     */
    private function verifierAccesBulletin(Bulletin $bulletin): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Vous devez être connecté.');
        }

        // Administrateur : accès complet.
        if (
            (int) $user->id === 1 ||
            $user->hasRole('Administrateur')
        ) {
            return;
        }

        // Directeur et enseignant : accès autorisé
        // si leur rôle dispose de la permission de consulter les bulletins.
        if (
            $user->hasRole('Directeur') ||
            $user->hasRole('Enseignant')
        ) {
            if ($user->aPermission('bulletins.afficher')) {
                return;
            }

            abort(403, 'Vous n’avez pas la permission de consulter les bulletins.');
        }

        // Élève : uniquement son propre bulletin.
        if ($user->hasRole('Eleve') || $user->hasRole('Élève')) {
            if (
                $user->eleve &&
                (int) $user->eleve->id === (int) $bulletin->eleve_id
            ) {
                return;
            }

            abort(403, 'Vous ne pouvez consulter que votre propre bulletin.');
        }

        // Parent : uniquement le bulletin d'un enfant associé à son compte.
        if ($user->hasRole('Parent')) {
            $parent = $user->parentEleve;

            if (
                $parent &&
                $parent->eleves()
                ->where('eleves.id', $bulletin->eleve_id)
                ->exists()
            ) {
                return;
            }

            abort(403, 'Vous ne pouvez consulter que les bulletins de vos enfants.');
        }

        abort(403, 'Accès au bulletin interdit.');
    }
    // =========================
    // PAGE SAISIE
    // =========================

    public function saisie()
    {
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Vous devez être connecté.');
        }

        if (! $user->aPermission('notes.voir')) {
            abort(403, 'Vous n’avez pas la permission de consulter la saisie des notes.');
        }

        $eleves   = Eleve::with('classe')->get();
        $periodes = Periode::all();

        return view(
            'bulletin.saisie',
            compact('eleves', 'periodes')
        );
    }

// =========================
// CHARGER ELEVE + MATIERES (AJAX)
// =========================

    public function getEleve($id)
    {
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Vous devez être connecté.');
        }

        if (! $user->aPermission('notes.voir')) {
            abort(403, 'Vous n’avez pas la permission de consulter les notes.');
        }

        $eleve    = Eleve::with('classe.matieres')->findOrFail($id);
        $periodes = Periode::all();

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
                'matieres'     => $eleve->classe->matieres,
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
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Vous devez être connecté.');
        }

        $request->validate([
            'eleve_id'       => 'required|integer|exists:eleves,id',
            'type'           => 'required|in:journalier,composition',
            'periode_id'     => 'required|integer|exists:periodes,id',
            'notes'          => 'required|array|min:1',
            'notes.*.valeur' => 'nullable|numeric|min:0',
            'notes.*.coef'   => 'nullable|numeric|min:0',
            'notes.*.base'   => 'nullable|numeric|min:0.01',
        ]);

        // Vérifier toutes les notes avant de commencer l'enregistrement.
        foreach ($request->notes as $matiereId => $data) {
            $noteExiste = Note::where('eleve_id', $request->eleve_id)
                ->where('matiere_id', $matiereId)
                ->where('type', $request->type)
                ->where('periode_id', $request->periode_id)
                ->exists();

            if ($noteExiste && ! $user->aPermission('notes.modifier')) {
                abort(403, 'Vous n’avez pas la permission de modifier les notes existantes.');
            }

            if (! $noteExiste && ! $user->aPermission('notes.creer')) {
                abort(403, 'Vous n’avez pas la permission de créer des notes.');
            }
        }

        foreach ($request->notes as $matiereId => $data) {
            Note::updateOrCreate(
                [
                    'eleve_id'   => $request->eleve_id,
                    'matiere_id' => $matiereId,
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

    public function afficherBulletin(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Vous devez être connecté.');
        }

        if (! $user->aPermission('bulletins.creer')) {
            abort(403, 'Vous n’avez pas la permission de générer un bulletin.');
        }

        $request->validate([
            'eleve_id'   => 'required|integer|exists:eleves,id',
            'periodes'   => 'required|array|min:1',
            'periodes.*' => 'required|integer|exists:periodes,id',
        ]);

        $eleve = Eleve::with('classe')
            ->findOrFail($request->eleve_id);

        $bulletins = [];

        foreach ($request->periodes as $periode_id) {
            $periode = Periode::findOrFail($periode_id);

            $notes = Note::where('eleve_id', $eleve->id)
                ->where('periode_id', $periode_id)
                ->with('matiere')
                ->get();

            $total = $notes->sum('valeur');
            $coef  = $notes->sum('coef');

            $moyenne = $coef > 0
                ? $total / $coef
                : 0;

            $bulletins[] = [
                'periode' => $periode,
                'notes'   => $notes,
                'moyenne' => $moyenne,
            ];
        }

        return view(
            'bulletin.affichage',
            compact('eleve', 'bulletins')
        );
    }
    // =========================
    // SAVE IMAGE BASE 64
    // =========================

    public function saveImage(Request $request)
    {
        $request->validate([
            'eleve_id'     => 'required|integer|exists:eleves,id',
            'image'        => 'required|string',
            'periodes_ids' => 'required|string',
        ]);

        // Vérifier que l'utilisateur est connecté.
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Vous devez être connecté.');
        }

        // Administrateur : accès complet.
        if (
            (int) $user->id !== 1 &&
            ! $user->hasRole('Administrateur')
        ) {
            // Vérifier que l'utilisateur a le droit de créer un bulletin.
            if (! $user->aPermission('bulletins.creer')) {
                abort(403, 'Vous n’avez pas la permission de créer un bulletin.');
            }
        }

        // Vérifier que l'image est bien une image encodée en Base64.
        if (! preg_match(
            '/^data:image\/(png|jpeg|jpg|gif|webp);base64,(.*)$/s',
            $request->image,
            $matches
        )) {
            return response()->json([
                'ok'      => false,
                'message' => 'Le format de l’image est invalide.',
            ], 422);
        }

        $imageDecodee = base64_decode($matches[2], true);

        if ($imageDecodee === false) {
            return response()->json([
                'ok'      => false,
                'message' => 'Impossible de décoder l’image.',
            ], 422);
        }

        // Vérifier le véritable type de fichier.
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($imageDecodee);

        if (! in_array($mime, [
            'image/png',
            'image/jpeg',
            'image/gif',
            'image/webp',
        ], true)) {
            return response()->json([
                'ok'      => false,
                'message' => 'Le contenu fourni n’est pas une image valide.',
            ], 422);
        }

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
            report($e);

            return response()->json([
                'ok'      => false,
                'message' => 'Une erreur est survenue lors de l’enregistrement du bulletin.',
            ], 500);
        }
    }

    public function voirImage($id)
    {
        $bulletin = Bulletin::with('eleve')->findOrFail($id);

        $this->verifierAccesBulletin($bulletin);

        return view(
            'bulletin.voir',
            compact('bulletin')
        );
    }

    public function downloadImage($id)
    {
        $bulletin = Bulletin::with('eleve')->findOrFail($id);

        $this->verifierAccesBulletin($bulletin);

        abort_unless(
            Auth::user()->aPermission('bulletins.telecharger'),
            403,
            'Vous n’avez pas la permission de télécharger les bulletins.'
        );

        $data = $bulletin->image_base64;

        // Vérifier qu'il s'agit bien d'une Data URI
        if (! preg_match('/^data:image\/[a-zA-Z0-9.+-]+;base64,(.*)$/s', $data, $matches)) {
            abort(422, 'Le contenu de l’image du bulletin est invalide.');
        }

        $image = base64_decode($matches[1], true);

        if ($image === false) {
            abort(422, 'Impossible de décoder l’image du bulletin.');
        }

        // Détecter le vrai type de l'image
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($image);

        // Sécurité : vérifier que c'est bien une image
        if (! str_starts_with($mime, 'image/')) {
            abort(422, 'Le fichier enregistré n’est pas une image valide.');
        }

        // Déterminer l'extension réelle
        $extension = match ($mime) {
            'image/png'  => 'png',
            'image/jpeg' => 'jpg',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
            default      => 'bin',
        };

        return response($image)
            ->header('Content-Type', $mime)
            ->header(
                'Content-Disposition',
                'attachment; filename="bulletin_' . $id . '.' . $extension . '"'
            );
    }
    public function printImage($id)
    {
        $bulletin = Bulletin::with('eleve')->findOrFail($id);

        $this->verifierAccesBulletin($bulletin);

        abort_unless(
            Auth::user()->aPermission('bulletins.imprimer'),
            403,
            'Vous n’avez pas la permission d’imprimer les bulletins.'
        );

        return view(
            'bulletin.print',
            compact('bulletin')
        );
    }

    public function generer()
    {
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Vous devez être connecté.');
        }

        if (! $user->aPermission('bulletins.voir')) {
            abort(403, 'Vous n’avez pas la permission de consulter la liste des bulletins.');
        }

        $eleves   = Eleve::with('classe')->get();
        $periodes = Periode::all();

        return view(
            'bulletin.generer',
            compact('eleves', 'periodes')
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

        // Vérifier si le bulletin existe.
        if (! $bulletin) {
            return back()->with(
                'error',
                'Aucun bulletin enregistré pour ces périodes.'
            );
        }

        // Vérifier les droits d'accès.
        $this->verifierAccesBulletin($bulletin);

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

        // Vérifier les droits d'accès.
        $this->verifierAccesBulletin($bulletin);

        $image = str_replace(
            'data:image/png;base64,',
            '',
            $bulletin->image_base64
        );

        $imageDecodee = base64_decode($image, true);

        if ($imageDecodee === false) {
            abort(422, 'Impossible de décoder l’image du bulletin.');
        }

        return response($imageDecodee)
            ->header('Content-Type', 'image/png')
            ->header(
                'Content-Disposition',
                'attachment; filename="bulletin.png"'
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

        // Vérifier les droits d'accès.
        $this->verifierAccesBulletin($bulletin);

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

        // Vérifier les droits d'accès.
        $this->verifierAccesBulletin($bulletin);

        $data = $bulletin->image_base64;

        // Vérifier et extraire le Base64.
        if (
            ! preg_match(
                '/^data:image\/[a-zA-Z0-9.+-]+;base64,(.*)$/s',
                $data,
                $matches
            )
        ) {
            abort(422, 'Le contenu de l’image du bulletin est invalide.');
        }

        $image = base64_decode($matches[1], true);

        if ($image === false) {
            abort(422, 'Impossible de décoder l’image du bulletin.');
        }

        // Détecter le véritable type de l'image.
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($image);

        if (! in_array($mime, [
            'image/png',
            'image/jpeg',
            'image/gif',
            'image/webp',
        ], true)) {
            abort(422, 'Le fichier enregistré n’est pas une image valide.');
        }

        $extension = match ($mime) {
            'image/png'  => 'png',
            'image/jpeg' => 'jpg',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        };

        return response($image)
            ->header('Content-Type', $mime)
            ->header(
                'Content-Disposition',
                'attachment; filename="bulletin.' . $extension . '"'
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

        // Vérifier les droits d'accès.
        $this->verifierAccesBulletin($bulletin);

        $pdf = Pdf::loadView(
            'bulletin.pdf',
            compact('bulletin')
        );

        return $pdf->download('bulletin.pdf');
    }

}