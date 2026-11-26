<?php

namespace App\Http\Controllers;

use App\Models\ActiviteParascolaire;
use App\Models\AnneeScolaire;
use App\Models\InscriptionActivite;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EspaceParentActiviteController extends Controller
{
    /**
     * Afficher les activités disponibles.
     */
    public function index(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_if(
            ! $parent,
            403,
            'Aucune fiche parent associée à votre compte.'
        );

        $parent->load('eleves');

        $activites = ActiviteParascolaire::where('actif', true)
            ->orderBy('nom')
            ->get();

        $anneeActive = AnneeScolaire::where('active', true)->first();

        return view('parent.activites.index', compact(
            'parent',
            'activites',
            'anneeActive'
        ));
    }

    /**
     * Enregistrer une demande d'inscription.
     */
    public function store(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_if(
            ! $parent,
            403,
            'Aucune fiche parent associée à votre compte.'
        );

        $validated = $request->validate([
            'eleve_id' => ['required', 'integer'],
            'activite_parascolaire_id' => ['required', 'integer'],
        ]);

        // Vérifier que l'enfant appartient bien au parent connecté.
        $eleve = $parent->eleves()
            ->where('eleves.id', $validated['eleve_id'])
            ->first();

        abort_if(
            ! $eleve,
            403,
            'Vous ne pouvez pas inscrire cet élève.'
        );

        // Vérifier que l'activité est disponible.
        $activite = ActiviteParascolaire::where('actif', true)
            ->findOrFail($validated['activite_parascolaire_id']);

        // Récupérer l'année scolaire active.
        $annee = AnneeScolaire::where('active', true)->first();

        if (! $annee) {
            throw ValidationException::withMessages([
                'activite_parascolaire_id' =>
                    'Aucune année scolaire active n’est disponible.',
            ]);
        }

        // Empêcher une double inscription.
        $dejaInscrit = InscriptionActivite::where(
            'eleve_id',
            $eleve->id
        )
            ->where(
                'activite_parascolaire_id',
                $activite->id
            )
            ->where(
                'annee_scolaire_id',
                $annee->id
            )
            ->exists();

        if ($dejaInscrit) {
            throw ValidationException::withMessages([
                'activite_parascolaire_id' =>
                    'Cet élève possède déjà une demande pour cette activité cette année.',
            ]);
        }

        InscriptionActivite::create([
            'eleve_id' => $eleve->id,
            'activite_parascolaire_id' => $activite->id,
            'annee_scolaire_id' => $annee->id,
            'date_demande' => now()->toDateString(),
            'tarif_applique' => $activite->tarif_indicatif ?? 0,
            'statut' => 'en_attente',
        ]);

        return redirect()
            ->route('parent.activites.demandes')
            ->with(
                'success',
                'Votre demande d’inscription a été envoyée avec succès.'
            );
    }

    /**
     * Afficher uniquement les demandes du parent connecté.
     */
    public function mesDemandes(Request $request)
    {
        $parent = $request->user()->parentEleve;

        abort_if(! $parent, 403);

        $elevesIds = $parent->eleves()
            ->pluck('eleves.id');

        $demandes = InscriptionActivite::with([
            'eleve',
            'activite',
            'anneeScolaire',
        ])
            ->whereIn('eleve_id', $elevesIds)
            ->latest()
            ->get();

        return view('parent.activites.demandes', compact(
            'parent',
            'demandes'
        ));
    }
}
