<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Periode;
use App\Models\Bulletin;
use App\Models\EleveFrais;
use App\Models\Paiement;
class EspaceParentController extends Controller
{
    /**
     * Tableau de bord personnel du parent.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $parent = $user->parentEleve;

        abort_if(
            ! $parent,
            403,
            'Aucune fiche parent n’est associée à votre compte.'
        );

        $parent->load([
            'eleves' => function ($query) {
                $query->orderBy('nom')
                    ->orderBy('prenom');
            },
        ]);

        return view('parent.dashboard', compact('parent'));
    }

    /**
     * Consulter les informations des enfants.
     */
    public function mesEnfants(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_if(! $parent, 403);

        $eleves = $parent->eleves()
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('parent.enfants', compact('parent', 'eleves'));
    }

    /**
     * Consulter les emplois du temps publiés des enfants.
     */
    public function emploiTemps(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_if(
            ! $parent,
            403,
            'Aucune fiche parent associée à votre compte.'
        );

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

        $jours = [
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi',
        ];

        return view(
            'parent.emploi-temps',
            compact('parent', 'eleves', 'jours')
        );
    }

    /**
     * Consulter les notes et bulletins des enfants.
     */
    public function notes(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_if(
            ! $parent,
            403,
            'Aucune fiche parent associée à votre compte.'
        );

        // Récupérer uniquement les enfants associés au parent.
        $eleves = $parent->eleves()
            ->with('classe')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        // Sélection de l'enfant.
        $enfantId = $request->query('enfant');

        if ($enfantId !== null) {

            abort_unless(
                ctype_digit((string) $enfantId),
                404
            );

            $enfant = $eleves->firstWhere(
                'id',
                (int) $enfantId
            );

            abort_if(
                ! $enfant,
                404,
                'Cet élève ne fait pas partie de votre espace parent.'
            );

        } else {

            $enfant = $eleves->first();
        }

        $notes = collect();
        $bulletins = collect();

        if ($enfant) {

            // Récupérer les notes de l'enfant.
            $notes = Note::with([
                    'matiere',
                    'periode',
                ])
                ->where('eleve_id', $enfant->id)
                ->orderBy('periode_id')
                ->orderBy('matiere_id')
                ->orderBy('type')
                ->get();

            // Récupérer les bulletins de l'enfant.
            $bulletins = Bulletin::where(
                    'eleve_id',
                    $enfant->id
                )
                ->latest()
                ->get();

            foreach ($bulletins as $bulletin) {

                $bulletin->image_src = null;
                $bulletin->periode_noms = [];

                // Vérifier l'image Base64.
                $image = $bulletin->image_base64;

                if (
                    is_string($image) &&
                    preg_match(
                        '/^data:image\/(png|jpeg|jpg|gif|webp);base64,(.*)$/s',
                        $image,
                        $matches
                    )
                ) {
                    $decoded = base64_decode(
                        $matches[2],
                        true
                    );

                    if ($decoded !== false) {
                        $bulletin->image_src = $image;
                    }
                }

                // Récupérer les périodes du bulletin.
                $ids = array_filter(
                    array_map(
                        'intval',
                        explode(
                            ',',
                            (string) $bulletin->periodes_ids
                        )
                    ),
                    fn ($id) => $id > 0
                );

                if (! empty($ids)) {

                    $bulletin->periode_noms = Periode::whereIn(
                            'id',
                            $ids
                        )
                        ->orderBy('date_debut')
                        ->pluck('nom')
                        ->toArray();
                }
            }
        }

        return view(
            'parent.notes',
            compact(
                'parent',
                'eleves',
                'enfant',
                'notes',
                'bulletins'
            )
        );
    }
    /**
 * Consulter les frais et écolages des enfants du parent.
 * Consultation uniquement : aucune opération financière.
 */
public function frais(Request $request)
{
    $parent = $request->user()->parentEleve;

    abort_if(
        !$parent,
        403,
        'Aucune fiche parent n’est associée à votre compte.'
    );

    // Récupérer uniquement les enfants liés au parent connecté.
    $eleves = $parent->eleves()
        ->with('classe')
        ->orderBy('nom')
        ->orderBy('prenom')
        ->get();

    $idsEleves = $eleves->pluck('id');

    // Récupérer les frais et calculer uniquement les paiements validés.
    $frais = EleveFrais::query()
        ->whereIn('eleve_id', $idsEleves)
        ->withSum([
            'detailsPaiements as montant_paye' => function ($query) {
                $query->whereHas('paiement', function ($paiementQuery) {
                    $paiementQuery->where('statut', 'valide');
                });
            }
        ], 'montant_paye')
        ->orderBy('date_echeance')
        ->get();

    // Calculer le montant payé et le reste pour chaque frais.
    foreach ($frais as $ligne) {
        $montantDu = (float) $ligne->montant_du;
        $montantPaye = (float) ($ligne->montant_paye ?? 0);

        $reste = max(0, round($montantDu - $montantPaye, 2));

        $ligne->setAttribute('montant_paye', $montantPaye);
        $ligne->setAttribute('reste_a_payer', $reste);

        // Déterminer le statut réel à partir des paiements validés.
        if ($reste <= 0.009) {
            $statutReel = 'paye';
        } elseif ($montantPaye > 0) {
            $statutReel = 'partiel';
        } else {
            $statutReel = 'impaye';
        }

        $ligne->setAttribute('statut_reel', $statutReel);
    }

    // Regrouper les frais par enfant.
    $fraisParEleve = $frais->groupBy('eleve_id');

    return view('parent.frais', compact(
        'parent',
        'eleves',
        'frais',
        'fraisParEleve'
    ));
}
public function historiquePaiements(Request $request)
{
    $parent = $request->user()->parentEleve;

    abort_if(
        !$parent,
        403,
        'Aucune fiche parent n’est associée à votre compte.'
    );

    // Récupérer uniquement les enfants liés au parent connecté.
    $eleves = $parent->eleves()
        ->with('classe')
        ->orderBy('nom')
        ->orderBy('prenom')
        ->get();

    $idsEleves = $eleves->pluck('id');

    // Récupérer les paiements de ces enfants uniquement.
    $paiements = Paiement::query()
        ->whereIn('eleve_id', $idsEleves)
        ->with([
            'eleve.classe',
            'details.eleveFrais',
        ])
        ->orderByDesc('date_paiement')
        ->get();

    return view('parent.historique-paiements', compact(
        'parent',
        'eleves',
        'paiements'
    ));
}
}
