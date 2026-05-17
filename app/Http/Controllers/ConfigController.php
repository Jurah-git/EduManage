<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    | STORE USER
    |--------------------------------------------------------------------------
    */

    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('config.users.list')
            ->with('success', 'Utilisateur ajouté avec succès');
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