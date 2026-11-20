<?php
namespace App\Http\Controllers;

use App\Models\ClasseMatiereCoefficient;
use App\Models\Matiere;
use Illuminate\Http\Request;

class CoefficientController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES MATIERES
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        abort_unless(auth()->user()->aPermission('coefficients.voir'), 403);

        $matieres = Matiere::all();

        return view(
            'matieres.coefficients.index',
            compact('matieres')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFIER LES COEFFICIENTS
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        abort_unless(auth()->user()->aPermission('coefficients.modifier'), 403);

        $matiere = Matiere::with('classes')->findOrFail($id);

        $classes = $matiere->classes;

        $coefficients = [];

        foreach ($classes as $classe) {

            $c = ClasseMatiereCoefficient::where('classe_id', $classe->id)
                ->where('matiere_id', $id)
                ->first();

            $coefficients[$classe->id] = $c?->coef ?? 1;
        }

        return view(
            'matieres.coefficients.edit',
            compact('matiere', 'classes', 'coefficients')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER LES COEFFICIENTS
    |--------------------------------------------------------------------------
    */
    public function save(Request $request, $id)
    {
        abort_unless(auth()->user()->aPermission('coefficients.modifier'), 403);

        $request->validate([
            'coef'   => ['required', 'array'],
            'coef.*' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($request->coef as $classe_id => $coef) {

            ClasseMatiereCoefficient::updateOrCreate(
                [
                    'classe_id'  => $classe_id,
                    'matiere_id' => $id,
                ],
                [
                    'coef' => $coef,
                ]
            );
        }

        return back()->with('success', 'Coefficient enregistré');
    }
}