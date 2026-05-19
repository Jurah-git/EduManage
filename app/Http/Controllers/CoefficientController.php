<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Classe;

use App\Models\ClasseMatiereCoefficient;

use Illuminate\Http\Request;

class CoefficientController
extends Controller
{

    public function index()
    {

        $matieres =
            Matiere::all();

        return view(

            'matieres.coefficients.index',

            compact(
                'matieres'
            )

        );
    }

    public function edit($id)
    {

        $matiere =

            Matiere::with(
                'classes'
            )

            ->findOrFail($id);

        $classes =

            $matiere->classes;

        $coefficients = [];

        foreach (
            $classes
            as $classe
        ) {

            $c =

                ClasseMatiereCoefficient

                ::where(

                    'classe_id',

                    $classe->id

                )

                ->where(

                    'matiere_id',

                    $id

                )

                ->first();

            $coefficients[$classe->id] =

                $c?->coef ?? 1;
        }

        return view(

            'matieres.coefficients.edit',

            compact(

                'matiere',

                'classes',

                'coefficients'

            )

        );
    }

    public function save(
        Request $request,
        $id
    ) {

        foreach (
            $request->coef
            as $classe_id => $coef
        ) {

            ClasseMatiereCoefficient

                ::updateOrCreate(

                    [

                        'classe_id' =>
                        $classe_id,

                        'matiere_id' =>
                        $id

                    ],

                    [

                        'coef' => $coef

                    ]

                );
        }

        return back()

            ->with(

                'success',

                'Coefficient enregistré'

            );
    }
}
