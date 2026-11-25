<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private array $modules = [
        'eleves'       => 'Élèves',
        'classes'      => 'Classes',
        'matieres'     => 'Matières',
        'enseignants'  => 'Enseignants',
        'notes'        => 'Notes',
        'bulletins'    => 'Bulletins',
        'emploi_temps' => 'Emploi du temps',
        'cahier_texte' => 'Cahier de texte',
        'bibliotheque' => 'Bibliothèque',
        'parents'      => 'Parents',
        'presences'    => 'Présences',
        'inscriptions' => 'Inscriptions',
        'paiements'    => 'Paiements',
        'frais'        => 'Frais et Écolages',
        'utilisateurs' => 'Utilisateurs',
        'rapports'     => 'Rapports',

        'periodes'     => 'Périodes',
        'coefficients' => 'Coefficients',
        'salles'       => 'Salles',

    ];

    private array $permissionsParModule = [
        'eleves'       => [
            'voir'      => 'Consulter',
            'creer'     => 'Ajouter un élève',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'classes'      => [
            'voir'      => 'Consulter',
            'creer'     => 'Créer une classe',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'matieres'     => [
            'voir'      => 'Consulter',
            'creer'     => 'Ajouter une matière',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'enseignants'  => [
            'voir'      => 'Consulter',
            'show'      => 'Voir',
            'creer'     => 'Ajouter',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'notes'        => [
            'voir' => 'Consulter',

        ],

        'bulletins'    => [
            'voir'        => 'Consulter la liste',
            'creer'       => 'Générer',
            'afficher'    => 'Voir',
            'telecharger' => 'Télécharger',
            'imprimer'    => 'Imprimer',
        ],

        'emploi_temps' => [
            'voir'      => 'Consulter',
            'show'      => 'Voir les détails',
            'creer'     => 'Ajouter',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
            'valider'   => 'Publier / Dépublier',
        ],

        'cahier_texte' => [
            'voir'      => 'Consulter',
            'creer'     => 'Ajouter une séance',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
            'valider'   => 'Valider',
        ],

        'bibliotheque' => [
            'voir'      => 'Consulter',
            'creer'     => 'Ajouter un livre',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'parents'      => [
            'voir'      => 'Consulter',
            'creer'     => 'Ajouter un parent',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'presences'    => [
            'voir'     => 'Consulter',
            'creer'    => 'Enregistrer les présences',
            'modifier' => 'Modifier',
            'valider'  => 'Valider',
        ],

        'inscriptions' => [
            'voir'     => 'Consulter',
            'creer'    => 'Inscrire un élève',
            'modifier' => 'Modifier',
            'valider'  => 'Valider une inscription',
        ],

        'paiements'    => [
            'voir'      => 'Consulter',
            'creer'     => 'Enregistrer un paiement',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
            'valider'   => 'Valider un paiement',
        ],

        'frais'        => [
            'dashboard'         => 'Tableau de bord financier',

            'types_voir'        => 'Consulter les types de frais',
            'types_creer'       => 'Ajouter un type de frais',
            'types_modifier'    => 'Modifier un type de frais',
            'types_supprimer'   => 'Supprimer un type de frais',

            'tarifs_voir'       => 'Consulter les tarifs scolaires',
            'tarifs_gerer'      => 'Gérer les tarifs scolaires',

            'situations_voir'   => 'Consulter les situations financières',

            'encaisser'         => 'Enregistrer un paiement',

            'paiements_voir'    => 'Consulter les paiements',
            'paiements_annuler' => 'Annuler un paiement',

            'recus_voir'        => 'Consulter les reçus',
            'recus_imprimer'    => 'Imprimer les reçus',

            'rapports_voir'     => 'Consulter les rapports financiers',
        ],

        'utilisateurs' => [
            'voir'      => 'Consulter',
            'creer'     => 'Créer un utilisateur',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'rapports'     => [
            'voir' => 'Consulter les rapports',
        ],

        'periodes'     => [
            'voir'      => 'Consulter',
            'creer'     => 'Créer une période',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],

        'coefficients' => [
            'voir'     => 'Consulter',
            'modifier' => 'Configurer',
        ],

        'salles'       => [
            'voir'      => 'Consulter',
            'creer'     => 'Ajouter une salle',
            'modifier'  => 'Modifier',
            'supprimer' => 'Supprimer',
        ],
    ];

    private function estAdministrateur(Role $role): bool
    {
        return mb_strtolower($role->name) === 'administrateur';
    }

    public function index()
    {
        $roles = Role::withCount('permissions')
            ->orderBy('name')
            ->get();

        return view('config.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('config.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
        ]);

        if (mb_strtolower(trim($validated['name'])) === 'administrateur') {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Le rôle Administrateur est réservé.',
                ]);
        }

        Role::create([
            'name'       => trim($validated['name']),
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('config.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    public function editPermissions(Role $role)
    {
        abort_if(
            $this->estAdministrateur($role),
            403,
            'Les permissions du rôle Administrateur ne peuvent pas être modifiées.'
        );

        $modules              = $this->modules;
        $permissionsParModule = $this->permissionsParModule;

        $nomsAutorises = collect($permissionsParModule)
            ->flatMap(function ($actionsDuModule, $module) {
                return collect(array_keys($actionsDuModule))->map(
                    fn($action) => $module . '.' . $action
                );
            });

        $permissions = Permission::where('guard_name', 'web')
            ->whereIn('name', $nomsAutorises)
            ->orderBy('name')
            ->get();

        $selectedPermissions = $role->permissions
            ->pluck('name')
            ->all();

        return view('config.roles.permissions', compact(
            'role',
            'modules',
            'permissionsParModule',
            'permissions',
            'selectedPermissions'
        ));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        abort_if(
            $this->estAdministrateur($role),
            403,
            'Les permissions du rôle Administrateur ne peuvent pas être modifiées.'
        );

        $validated = $request->validate([
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'distinct', 'exists:permissions,name'],
        ]);

        $permissionsParModule = $this->permissionsParModule;

        // Construire la liste des permissions autorisées.
        $nomsAutorises = collect($permissionsParModule)
            ->flatMap(function ($actionsDuModule, $module) {
                return collect(array_keys($actionsDuModule))->map(
                    fn($action) => $module . '.' . $action
                );
            });

        $permissionsDemandees = collect($validated['permissions'] ?? []);

        // Vérifier que les permissions demandées sont autorisées.
        $nomsInterdits = $permissionsDemandees->diff($nomsAutorises);

        if ($nomsInterdits->isNotEmpty()) {
            return back()
                ->withInput()
                ->withErrors([
                    'permissions' => 'Une ou plusieurs permissions ne sont pas autorisées.',
                ]);
        }

        // Récupérer uniquement les permissions du guard web.
        $permissions = Permission::where('guard_name', 'web')
            ->whereIn('name', $permissionsDemandees)
            ->get();

        // Enregistrer les permissions du rôle.
        $role->syncPermissions($permissions);

        return redirect()
            ->route('config.roles.index')
            ->with(
                'success',
                'Permissions du rôle « ' . $role->name . ' » enregistrées.'
            );
    }

    public function destroy(Role $role)
    {
        if ($this->estAdministrateur($role)) {
            return back()->with(
                'error',
                'Le rôle Administrateur ne peut pas être supprimé.'
            );
        }

        if ($role->users()->exists()) {
            return back()->with(
                'error',
                'Ce rôle est attribué à un utilisateur. Retirez-le avant de le supprimer.'
            );
        }

        $role->delete();

        return redirect()
            ->route('config.roles.index')
            ->with('success', 'Rôle supprimé avec succès.');
    }
}