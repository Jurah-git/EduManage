<?php

namespace App\Http\Controllers;

use App\Models\CreneauEmploiTemps;
use App\Models\EmploiTemps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreneauEmploiTempsController extends Controller
{
    /**
     * Ajouter un créneau horaire à un emploi du temps.
     */
    public function store(Request $request, EmploiTemps $emploiTemps)
    {
        // Vérifier que l'emploi du temps n'est pas publié.
        if ($emploiTemps->statut === 'publie') {
            return back()->with(
                'error',
                "Impossible de modifier un emploi du temps publié."
            );
        }

        // Valider les données du formulaire.
        $validated = $request->validate([
            'matiere_id' => [
                'required',
                'integer',
                'exists:matieres,id',
            ],

            'enseignant_id' => [
                'required',
                'integer',
                'exists:enseignants,id',
            ],

            'salle_id' => [
                'required',
                'integer',
                'exists:salles,id',
            ],

            'jour' => [
                'required',
                'in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            ],

            'heure_debut' => [
                'required',
                'date_format:H:i',
            ],

            'heure_fin' => [
                'required',
                'date_format:H:i',
                'after:heure_debut',
            ],
        ], [
            'matiere_id.required' => 'Veuillez sélectionner une matière.',
            'matiere_id.exists' => 'La matière sélectionnée est introuvable.',

            'enseignant_id.required' => 'Veuillez sélectionner un enseignant.',
            'enseignant_id.exists' => "L'enseignant sélectionné est introuvable.",

            'salle_id.required' => 'Veuillez sélectionner une salle.',
            'salle_id.exists' => 'La salle sélectionnée est introuvable.',

            'jour.required' => 'Veuillez sélectionner un jour.',
            'jour.in' => 'Le jour sélectionné est invalide.',

            'heure_debut.required' => "Veuillez renseigner l'heure de début.",
            'heure_debut.date_format' => "Le format de l'heure de début est invalide.",

            'heure_fin.required' => "Veuillez renseigner l'heure de fin.",
            'heure_fin.date_format' => "Le format de l'heure de fin est invalide.",
            'heure_fin.after' => "L'heure de fin doit être postérieure à l'heure de début.",
        ]);

        /*
         * Vérifier que la matière est associée
         * à la classe de cet emploi du temps.
         *
         * Cette vérification suppose que la table pivot
         * s'appelle classe_matiere.
         */
        $matiereAutorisee = DB::table('classe_matiere')
            ->where('classe_id', $emploiTemps->classe_id)
            ->where('matiere_id', $validated['matiere_id'])
            ->exists();

        if (!$matiereAutorisee) {
            return back()
                ->withInput()
                ->withErrors([
                    'matiere_id' =>
                        "Cette matière n'est pas associée à la classe sélectionnée.",
                ]);
        }

        /*
         * Vérifier les conflits horaires dans la même
         * année scolaire.
         *
         * Un conflit existe si :
         * - la classe a déjà un cours ;
         * - l'enseignant enseigne déjà ailleurs ;
         * - la salle est déjà occupée.
         *
         * Deux créneaux qui se touchent exactement
         * (par exemple 08:00-09:00 et 09:00-10:00)
         * ne sont pas considérés comme un chevauchement.
         */
        $chevauchement = CreneauEmploiTemps::query()
            ->where('jour', $validated['jour'])

            ->where(
                'heure_debut',
                '<',
                $validated['heure_fin']
            )

            ->where(
                'heure_fin',
                '>',
                $validated['heure_debut']
            )

            ->whereHas('emploiTemps', function ($query) use ($emploiTemps) {
                $query->where(
                    'annee_scolaire_id',
                    $emploiTemps->annee_scolaire_id
                );
            })

            ->where(function ($query) use ($emploiTemps, $validated) {

                // Même classe.
                $query->whereHas(
                    'emploiTemps',
                    function ($sousQuery) use ($emploiTemps) {
                        $sousQuery->where(
                            'classe_id',
                            $emploiTemps->classe_id
                        );
                    }
                )

                // Ou même enseignant.
                ->orWhere(
                    'enseignant_id',
                    $validated['enseignant_id']
                )

                // Ou même salle.
                ->orWhere(
                    'salle_id',
                    $validated['salle_id']
                );
            })

            ->exists();

        if ($chevauchement) {
            return back()
                ->withInput()
                ->withErrors([
                    'heure_debut' =>
                        "Conflit horaire : cette classe, cet enseignant ou cette salle est déjà occupé sur ce créneau.",
                ]);
        }

        // Enregistrer le créneau.
        $emploiTemps->creneaux()->create($validated);

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with(
                'success',
                'Le créneau horaire a été ajouté avec succès.'
            );
    }

    /**
     * Supprimer un créneau horaire.
     */
    public function destroy(
        EmploiTemps $emploiTemps,
        CreneauEmploiTemps $creneau
    ) {
        // Interdire la suppression si l'emploi du temps est publié.
        if ($emploiTemps->statut === 'publie') {
            return back()->with(
                'error',
                "Impossible de modifier un emploi du temps publié."
            );
        }

        // Vérifier que le créneau appartient bien à cet emploi du temps.
        if ((int) $creneau->emploi_temps_id !== (int) $emploiTemps->id) {
            abort(404);
        }

        // Supprimer le créneau.
        $creneau->delete();

        return redirect()
            ->route('emplois-temps.show', $emploiTemps)
            ->with(
                'success',
                'Le créneau horaire a été supprimé avec succès.'
            );
    }
}