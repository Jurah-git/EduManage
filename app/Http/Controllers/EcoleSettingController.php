<?php
namespace App\Http\Controllers;

use App\Models\EcoleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EcoleSettingController extends Controller
{
    public function index()
    {
        $ecole = EcoleSetting::first();

        return view('config.ecole-identite', compact('ecole'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom_ecole'      => 'nullable|string|max:255',
            'adresse'        => 'nullable|string|max:255',
            'telephone'      => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:255',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'supprimer_logo' => 'nullable|boolean',
        ]);

        $ecole = EcoleSetting::firstOrCreate([]);

        $ecole->nom_ecole = $request->nom_ecole;
        $ecole->adresse   = $request->adresse;
        $ecole->telephone = $request->telephone;
        $ecole->email     = $request->email;

        // SUPPRESSION DU LOGO
        if ($request->boolean('supprimer_logo')) {

            if ($ecole->logo && Storage::disk('public')->exists($ecole->logo)) {
                Storage::disk('public')->delete($ecole->logo);
            }

            $ecole->logo = null;
        }

        // AJOUT OU REMPLACEMENT DU LOGO
        elseif ($request->hasFile('logo')) {

            if ($ecole->logo && Storage::disk('public')->exists($ecole->logo)) {
                Storage::disk('public')->delete($ecole->logo);
            }

            $ecole->logo = $request->file('logo')->store('ecole', 'public');
        }

        $ecole->save();

        return redirect()
            ->route('config.ecole-identite')
            ->with('success', 'Les informations de l’école ont été mises à jour avec succès.');
    }

}