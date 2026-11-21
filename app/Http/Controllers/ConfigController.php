<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM AJOUT USER
    |--------------------------------------------------------------------------
    */

    public function usersCreate()
    {
        return view('config.users_create');
    }

    /*
    |--------------------------------------------------------------------------
    | LISTE USERS
    |--------------------------------------------------------------------------
    */

    public function usersList()
    {
        $users = User::latest()->get();

        return view('config.users_list', compact('users'));
    }

    /*
|--------------------------------------------------------------------------
| AFFICHER LES DETAILS D'UN UTILISATEUR
|--------------------------------------------------------------------------
*/

    public function usersShow(User $user)
    {
        return view('config.users_show', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE USER
    |--------------------------------------------------------------------------
    */

    public function usersStore(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:4',

            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'telephone'      => 'nullable|string|max:50',
            'sexe'           => 'nullable|in:Masculin,Féminin',
            'date_naissance' => 'nullable|date',
            'adresse'        => 'nullable|string|max:1000',
            'fonction'       => 'nullable|string|max:255',
            'statut'         => 'required|boolean',
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('users', 'public');
        }

        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),

            'photo'          => $photo,
            'telephone'      => $request->telephone,
            'sexe'           => $request->sexe,
            'date_naissance' => $request->date_naissance,
            'adresse'        => $request->adresse,
            'fonction'       => $request->fonction,
            'statut'         => $request->statut,
        ]);

        return redirect()
            ->route('config.users.list')
            ->with('success', 'Utilisateur ajouté avec succès');
    }

/*
|--------------------------------------------------------------------------
| FORMULAIRE MODIFICATION UTILISATEUR
|--------------------------------------------------------------------------
*/

    public function usersEdit(User $user)
    {
        return view('config.users_edit', compact('user'));
    }

/*
|--------------------------------------------------------------------------
| MODIFICATION UTILISATEUR
|--------------------------------------------------------------------------
*/

    public function usersUpdate(Request $request, User $user)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,

            'photo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'telephone'        => 'nullable|string|max:50',
            'sexe'             => 'nullable|in:Masculin,Féminin',
            'date_naissance'   => 'nullable|date',
            'adresse'          => 'nullable|string|max:1000',
            'fonction'         => 'nullable|string|max:255',
            'statut'           => 'required|boolean',
            'current_password' => 'nullable|string',
            'password'         => 'nullable|string|min:8|confirmed',
        ]);

        $user->name           = $request->name;
        $user->email          = $request->email;
        $user->telephone      = $request->telephone;
        $user->sexe           = $request->sexe;
        $user->date_naissance = $request->date_naissance;
        $user->adresse        = $request->adresse;
        $user->fonction       = $request->fonction;
        $user->statut         = $request->statut;

        // MODIFICATION DU MOT DE PASSE AVEC VERIFICATION DE L'ANCIEN
        if ($request->filled('password')) {

            // Vérifier que l'ancien mot de passe est fourni
            if (! $request->filled('current_password')) {
                return back()
                    ->withErrors(['current_password' => 'Veuillez saisir le mot de passe actuel.'])
                    ->withInput();
            }

            // Vérifier que l'ancien mot de passe correspond
            if (! Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                    ->withInput();
            }

            // Enregistrer le nouveau mot de passe
            $user->password = Hash::make($request->password);
        }

        // REMPLACEMENT DE LA PHOTO
        if ($request->hasFile('photo')) {

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $request->file('photo')->store('users', 'public');
        }

        $user->save();

        return redirect()
            ->route('config.users.edit', $user)
            ->with('success', 'Modifications enregistrées avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE USER
    |--------------------------------------------------------------------------
    */

    public function usersDelete(User $user)
    {
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé');
    }
}