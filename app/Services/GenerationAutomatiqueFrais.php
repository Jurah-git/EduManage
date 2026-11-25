<?php
namespace App\Services;

use App\Models\EleveFrais;
use App\Models\Inscription;
use App\Models\TarifFrais;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GenerationAutomatiqueFrais
{
    /**
     * Générer les frais d'inscription ou de réinscription
     * correspondant à une inscription validée.
     */
    public function genererFraisInscription(Inscription $inscription): int
    {
        if ($inscription->statut !== 'validee') {
            return 0;
        }

        $dateInscription = Carbon::parse($inscription->date_inscription);

        if ($inscription->type === 'nouvelle_inscription') {
            $frequence  = 'unique';
            $nomType    = "Frais d'inscription";
            $clePeriode = 'INS-UNIQUE';
        } elseif ($inscription->type === 'reinscription') {
            $frequence  = 'annuelle';
            $nomType    = 'Frais de réinscription';
            $clePeriode = 'INS-' . $inscription->annee_scolaire_id;
        } else {
            throw ValidationException::withMessages([
                'type' => "Le type d'inscription est invalide.",
            ]);
        }

        $tarifs = TarifFrais::with('typeFrais')
            ->where('annee_scolaire_id', $inscription->annee_scolaire_id)
            ->where('classe_id', $inscription->classe_id)
            ->where('actif', true)
            ->where(function ($query) use ($dateInscription) {
                $query->whereNull('date_debut')
                    ->orWhereDate('date_debut', '<=', $dateInscription);
            })
            ->where(function ($query) use ($dateInscription) {
                $query->whereNull('date_fin')
                    ->orWhereDate('date_fin', '>=', $dateInscription);
            })
            ->whereHas('typeFrais', function ($query) use ($nomType, $frequence) {
                $query->where('nom', $nomType)
                    ->where('frequence', $frequence)
                    ->where('actif', true);
            })
            ->get();

        if ($tarifs->isEmpty()) {
            throw ValidationException::withMessages([
                'tarif_frais' => "Aucun tarif actif correspondant n'a été trouvé pour {$nomType}, pour cette classe et cette année scolaire. Veuillez créer le tarif avant de valider l'inscription.",
            ]);
        }

// Vérifier si les frais d'inscription uniques
// ont déjà été générés pour cet élève.
        if ($clePeriode === 'INS-UNIQUE') {
            $dejaCree = EleveFrais::where('eleve_id', $inscription->eleve_id)
                ->where('cle_periode', 'INS-UNIQUE')
                ->whereHas('tarifFrais.typeFrais', function ($query) {
                    $query->where('nom', "Frais d'inscription")
                        ->where('frequence', 'unique');
                })
                ->exists();

            if ($dejaCree) {
                return 0;
            }
        }

        $crees = 0;

        DB::transaction(function () use (
            $inscription,
            $tarifs,
            $clePeriode,
            $dateInscription,
            &$crees
        ) {
            foreach ($tarifs as $tarif) {
                $dateEcheance = $tarif->date_debut
                    ? Carbon::parse($tarif->date_debut)
                    : $dateInscription->copy();

                $frais = EleveFrais::firstOrCreate(
                    [
                        'eleve_id'       => $inscription->eleve_id,
                        'tarif_frais_id' => $tarif->id,
                        'cle_periode'    => $clePeriode,
                    ],
                    [
                        'libelle'       => $tarif->typeFrais->nom,
                        'montant_du'    => $tarif->montant,
                        'mois'          => null,
                        'annee'         => $dateInscription->year,
                        'date_echeance' => $dateEcheance->toDateString(),
                        'statut'        => 'impaye',
                    ]
                );

                if ($frais->wasRecentlyCreated) {
                    $crees++;
                }
            }
        });

        return $crees;
    }
}