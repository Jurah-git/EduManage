<?php
namespace App\Http\Controllers;

use App\Models\EcoleSetting;
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

    /*
|--------------------------------------------------------------------------
| CONFIGURATION DU POINTAGE
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| CONFIGURATION DU POINTAGE
|--------------------------------------------------------------------------
*/

    public function pointage()
    {
        $setting = EcoleSetting::first();

        $valeursParDefaut = [
            'ouverture_portail'   => '07:15',
            'debut_matin'         => '07:30',
            'fin_matin'           => '12:00',
            'debut_apres_midi'    => '14:00',
            'fin_apres_midi'      => '17:00',
            'jours_cours'         => ['lun', 'mar', 'mer', 'jeu', 'ven'],
            'tolerance_retard'    => 10,
            'seuil_absence'       => 30,
            'mode_pointage'       => 'qr_badge',
            'jours_justification' => 3,
            'alerter_parents'     => true,
            'inclure_bulletin'    => true,
        ];

        $config = (object) array_merge(
            $valeursParDefaut,
            $setting?->pointage_config ?? []
        );

        return view('config.pointage', compact('config'));
    }

/*
|--------------------------------------------------------------------------
| ENREGISTRER LA CONFIGURATION DU POINTAGE
|--------------------------------------------------------------------------
*/

    public function updatePointage(Request $request)
    {
        $data = $request->validate([
            'ouverture_portail'   => 'required|date_format:H:i',
            'debut_matin'         => 'required|date_format:H:i',
            'fin_matin'           => 'required|date_format:H:i',
            'debut_apres_midi'    => 'required|date_format:H:i',
            'fin_apres_midi'      => 'required|date_format:H:i',

            'jours_cours'         => 'required|array|min:1',
            'jours_cours.*'       => 'required|in:lun,mar,mer,jeu,ven,sam',

            'tolerance_retard'    => 'required|integer|min:0|max:60',
            'seuil_absence'       => 'required|integer|min:5|max:240',

            'mode_pointage'       => 'required|in:qr_badge,appel_manuel,biometrie',

            'jours_justification' => 'nullable|integer|min:0|max:30',
        ]);

        // Gestion des cases à cocher
        $data['alerter_parents']  = $request->boolean('alerter_parents');
        $data['inclure_bulletin'] = $request->boolean('inclure_bulletin');

        // Valeur par défaut du délai de justification
        $data['jours_justification'] ??= 3;

        // Récupérer ou créer les paramètres de l'école
        $setting = EcoleSetting::first() ?? new EcoleSetting();

        // Enregistrer les paramètres dans la colonne JSON
        $setting->pointage_config = $data;
        $setting->save();

        return redirect()
            ->route('config.pointage')
            ->with('success', 'Configuration du pointage enregistrée avec succès.');
    }

    /*
|--------------------------------------------------------------------------
| CONFIGURATION DES MODES DE PAIEMENT
|--------------------------------------------------------------------------
*/

public function modePaiement()
{
    $setting = EcoleSetting::first();

    $modesParDefaut = [
        'especes' => [
            'nom' => 'Espèces',
            'description' => 'Paiement directement à la caisse.',
            'actif' => true,
            'details' => '',
        ],
        'mvola' => [
            'nom' => 'MVola',
            'description' => 'Paiement par transfert MVola.',
            'actif' => false,
            'details' => '',
        ],
        'orange_money' => [
            'nom' => 'Orange Money',
            'description' => 'Paiement par transfert Orange Money.',
            'actif' => false,
            'details' => '',
        ],
        'airtel_money' => [
            'nom' => 'Airtel Money',
            'description' => 'Paiement par transfert Airtel Money.',
            'actif' => false,
            'details' => '',
        ],
        'virement' => [
            'nom' => 'Virement bancaire',
            'description' => 'Paiement par virement bancaire.',
            'actif' => false,
            'details' => '',
        ],
        'cheque' => [
            'nom' => 'Chèque',
            'description' => 'Paiement par chèque.',
            'actif' => false,
            'details' => '',
        ],
    ];

    $modes = array_replace_recursive(
        $modesParDefaut,
        $setting?->modes_paiement_config ?? []
    );

    return view('config.mode_paiement', compact('modes'));
}

/*
|--------------------------------------------------------------------------
| ENREGISTRER LES MODES DE PAIEMENT
|--------------------------------------------------------------------------
*/


public function updateModePaiement(Request $request)
{
    $request->validate([
        'modes' => 'required|array',
        'modes.*.actif' => 'nullable|boolean',
        'modes.*.details' => 'nullable|string|max:255',
    ]);

    $modesParDefaut = [
        'especes' => [
            'nom' => 'Espèces',
            'description' => 'Paiement directement à la caisse.',
            'actif' => true,
            'details' => '',
        ],
        'mvola' => [
            'nom' => 'MVola',
            'description' => 'Paiement par transfert MVola.',
            'actif' => false,
            'details' => '',
        ],
        'orange_money' => [
            'nom' => 'Orange Money',
            'description' => 'Paiement par transfert Orange Money.',
            'actif' => false,
            'details' => '',
        ],
        'airtel_money' => [
            'nom' => 'Airtel Money',
            'description' => 'Paiement par transfert Airtel Money.',
            'actif' => false,
            'details' => '',
        ],
        'virement' => [
            'nom' => 'Virement bancaire',
            'description' => 'Paiement par virement bancaire.',
            'actif' => false,
            'details' => '',
        ],
        'cheque' => [
            'nom' => 'Chèque',
            'description' => 'Paiement par chèque.',
            'actif' => false,
            'details' => '',
        ],
    ];

    $setting = EcoleSetting::firstOrCreate([]);

    $modes = array_replace_recursive(
        $modesParDefaut,
        $setting->modes_paiement_config ?? []
    );

    foreach ($modes as $key => &$mode) {
        $mode['actif'] = (bool) (
            $request->input("modes.$key.actif", false)
        );

        $mode['details'] = $request->input(
            "modes.$key.details",
            ''
        );
    }

    unset($mode);

    $setting->modes_paiement_config = $modes;
    $setting->save();

    return redirect()
        ->route('config.mode.paiement')
        ->with('success', 'Les modes de paiement ont été enregistrés avec succès.');
}

}