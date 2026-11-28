<?php

use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\BibliothequeController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\CahierTexteController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CoefficientController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CreneauEmploiTempsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EcoleSettingController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EmploiTempsController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\FraisDashboardController;
use App\Http\Controllers\GenerationFraisController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ParentEleveController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RangMatiereController;
use App\Http\Controllers\RapportFinancierController;
use App\Http\Controllers\RecuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\SituationFinanciereController;
use App\Http\Controllers\TarifFraisController;
use App\Http\Controllers\TypeFraisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspaceParentController;
use App\Http\Controllers\EspaceParentActiviteController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\EspaceParentAnnonceController;
use App\Models\Note;
use App\Models\Periode;
use App\Models\Bulletin;
use App\Http\Controllers\EspaceParentMessagerieController;
use App\Http\Controllers\AdminMessagerieController;



/*
|--------------------------------------------------------------------------
| REDIRECTION
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

/*
|--------------------------------------------------------------------------
| IDENTITÉ DE L'ÉCOLE
|--------------------------------------------------------------------------
*/

    Route::middleware(['admin.only'])->group(function () {

    Route::get('/config/ecole-identite', [EcoleSettingController::class, 'index'])
        ->name('config.ecole-identite');

    Route::post('/config/ecole-identite', [EcoleSettingController::class, 'update'])
        ->name('config.ecole-identite.update');

});
/*
|--------------------------------------------------------------------------
| SALLE
|--------------------------------------------------------------------------
*/

    Route::resource('salles', SalleController::class)
        ->parameters(['salles' => 'salle']);

/*
|--------------------------------------------------------------------------
| ENSEIGNANTS
|--------------------------------------------------------------------------
*/

    Route::resource('enseignants', EnseignantController::class)
        ->parameters([
            'enseignants' => 'enseignant',
        ]);

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

/*
|--------------------------------------------------------------------------
| UTILISATEURS
|--------------------------------------------------------------------------
*/

    Route::middleware(['admin.only'])->group(function () {

        Route::get('/users/create', [ConfigController::class, 'usersCreate'])
            ->name('config.users.create');

        Route::get('/users', [ConfigController::class, 'usersList'])
            ->name('config.users.list');

        Route::post('/users/store', [ConfigController::class, 'usersStore'])
            ->name('config.users.store');

        Route::get('/users/{user}/edit', [ConfigController::class, 'usersEdit'])
            ->name('config.users.edit');

        Route::put('/users/{user}', [ConfigController::class, 'usersUpdate'])
            ->name('config.users.update');

        Route::delete('/users/{user}', [ConfigController::class, 'usersDelete'])
            ->name('config.users.delete');

        Route::get('/users/{user}/show', [ConfigController::class, 'usersShow'])
            ->name('config.users.show');

    });

    /*
    |--------------------------------------------------------------------------
    | CLASSES
    |--------------------------------------------------------------------------
    */

    Route::resource('classes', ClasseController::class)
        ->parameters([
            'classes' => 'classe',
        ]);

    /*
    |--------------------------------------------------------------------------
    | MATIÈRES
    |--------------------------------------------------------------------------
    */

    Route::resource('matieres', MatiereController::class);

    /*
    |--------------------------------------------------------------------------
    | COEFF
    |--------------------------------------------------------------------------
    */

    Route::prefix('coefficients')

        ->name('coefficients.')

        ->group(function () {

            Route::get(
                '/',
                [CoefficientController::class, 'index']
            )

                ->name('index');

            Route::get(
                '/matiere/{id}',
                [CoefficientController::class, 'edit']
            )

                ->name('edit');

            Route::post(
                '/save/{id}',
                [CoefficientController::class, 'save']
            )

                ->name('save');
        });

    /*
    |--------------------------------------------------------------------------
    | ÉLÈVES
    |--------------------------------------------------------------------------
    */

    Route::resource('eleves', EleveController::class)
        ->parameters([
            'eleves' => 'eleve',
        ]);

    /*
    |--------------------------------------------------------------------------
    | INSCRIPTIONS
    |--------------------------------------------------------------------------
    */

    Route::resource('inscriptions', InscriptionController::class)
        ->parameters([
            'inscriptions' => 'inscription',
        ]);

    /*
    |--------------------------------------------------------------------------
    | MODULE FRAIS ET ÉCOLAGES
    |--------------------------------------------------------------------------
    */

    Route::prefix('frais')
        ->name('frais.')
        ->group(function () {

            // TABLEAU DE BORD FINANCIER
            Route::get('/dashboard', [FraisDashboardController::class, 'index'])
                ->name('dashboard');

            // TYPES DE FRAIS
            Route::resource('types', TypeFraisController::class);

            // TARIFS SCOLAIRES
            Route::resource('tarifs', TarifFraisController::class);

            // SITUATION FINANCIÈRE DES ÉLÈVES
            Route::get('/situations', [SituationFinanciereController::class, 'index'])
                ->name('situations.index');

            Route::get('/situations/{eleve}', [SituationFinanciereController::class, 'show'])
                ->name('situations.show');

            // ENCAISSEMENTS
            Route::get('/paiements', [PaiementController::class, 'index'])
                ->name('paiements.index');

            Route::get('/paiements/create', [PaiementController::class, 'create'])
                ->name('paiements.create');

            Route::post('/paiements', [PaiementController::class, 'store'])
                ->name('paiements.store');

            Route::get('/paiements/{paiement}', [PaiementController::class, 'show'])
                ->name('paiements.show');

            Route::post('/paiements/{paiement}/annuler', [PaiementController::class, 'annuler'])
                ->name('paiements.annuler');

            // REÇUS DE PAIEMENT
            Route::get('/recus', [RecuController::class, 'index'])
                ->name('recus.index');

            Route::get('/recus/{recu}/imprimer', [RecuController::class, 'imprimer'])
                ->name('recus.imprimer');

            // RAPPORTS FINANCIERS
            Route::get('/rapports', [RapportFinancierController::class, 'index'])
                ->name('rapports.index');

            // Génération automatique des frais
            Route::get('/generation', [GenerationFraisController::class, 'index'])
                ->name('generation.index');

            Route::post('/generation', [GenerationFraisController::class, 'generer'])
                ->name('generation.generer');

        });

    /*
    |--------------------------------------------------------------------------
    | CAHIER DE TEXTE
    |--------------------------------------------------------------------------
    */

    Route::resource('cahier', CahierTexteController::class);

    /*
    |--------------------------------------------------------------------------
    | EMPLOI DU TEMPS
    |--------------------------------------------------------------------------
    */

    Route::resource('emplois-temps', EmploiTempsController::class)
        ->parameters(['emplois-temps' => 'emploiTemps'])
        ->except(['show']);

    Route::get(
        'emplois-temps/{emploiTemps}',
        [EmploiTempsController::class, 'show']
    )->name('emplois-temps.show');

    Route::patch(
        'emplois-temps/{emploiTemps}/publier',
        [EmploiTempsController::class, 'publier']
    )->name('emplois-temps.publier');

    Route::patch(
        'emplois-temps/{emploiTemps}/brouillon',
        [EmploiTempsController::class, 'brouillon']
    )->name('emplois-temps.brouillon');

/*
|--------------------------------------------------------------------------
| Créneaux de l'emploi du temps
|--------------------------------------------------------------------------
*/
    Route::post(
        'emplois-temps/{emploiTemps}/creneaux',
        [CreneauEmploiTempsController::class, 'store']
    )->name('emplois-temps.creneaux.store');

    Route::delete(
        'emplois-temps/{emploiTemps}/creneaux/{creneau}',
        [CreneauEmploiTempsController::class, 'destroy']
    )->name('emplois-temps.creneaux.destroy');

    /*
    |--------------------------------------------------------------------------
    | LIVRES
    |--------------------------------------------------------------------------
    */

    Route::resource('livres', LivreController::class);

    /*
    |--------------------------------------------------------------------------
    | BIBLIOTHÈQUE
    |--------------------------------------------------------------------------
    */

    Route::get('/biblio', [BibliothequeController::class, 'index'])
        ->name('biblio.index');

    Route::get('/biblio/emprunt', [BibliothequeController::class, 'emprunt'])
        ->name('biblio.emprunt');

    /*
    |--------------------------------------------------------------------------
    | MODULE PARENTS
    |--------------------------------------------------------------------------
    */

    Route::middleware(['admin.only'])->group(function () {
    Route::resource('parents', ParentEleveController::class);
});

    /*
    |--------------------------------------------------------------------------
    | PERIODE
    |--------------------------------------------------------------------------
    */
    Route::resource('periodes', PeriodeController::class);

    /*
    |--------------------------------------------------------------------------
    | BULLETIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('bulletin')

        ->name('bulletin.')

        ->group(function () {

            Route::get(

                '/saisie',

                [
                    BulletinController::class,

                    'saisie',
                ]

            )

                ->name(
                    'saisie'
                );

            Route::get(

                '/eleve/{id}',

                [
                    BulletinController::class,

                    'getEleve',
                ]

            )

                ->name(
                    'eleve'
                );

            Route::post(

                '/store',

                [
                    BulletinController::class,

                    'store',
                ]

            )

                ->name(
                    'store'
                );

            Route::get(

                '/generer',

                [

                    BulletinController::class,

                    'generer',

                ]

            )

                ->name(
                    'generer'
                );

            Route::post(

                '/verifier',

                [

                    BulletinController::class,

                    'verifierPeriodes',

                ]

            )

                ->name(
                    'verifier'
                );

            Route::post(

                '/afficher',

                [

                    BulletinController::class,

                    'afficherBulletin',

                ]

            )

                ->name(
                    'afficher'
                );

            Route::get(
                '/affichage',
                [BulletinController::class, 'afficherBulletinGet']
            )->name('affichageGet');

            Route::post(

                '/save-image',

                [

                    BulletinController::class,

                    'saveImage',

                ]

            )

                ->name(

                    'saveImage'

                );

            Route::get(

                '/voir/{id}',

                [

                    BulletinController::class,

                    'voirImage',

                ]

            )

                ->name(

                    'voirImage'
                );

            Route::get(
                '/download/{id}',
                [BulletinController::class, 'downloadImage']
            )->name('downloadImage');

            Route::get(
                '/print/{id}',
                [BulletinController::class, 'printImage']
            )->name('printImage');

            Route::get(
                '/voir-direct',
                [BulletinController::class, 'voirDirect']
            )->name('voirDirect');

            Route::get(
                '/download-direct',
                [BulletinController::class, 'downloadDirect']
            )->name('downloadDirect');

            Route::get(
                '/print-direct',
                [BulletinController::class, 'printDirect']
            )->name('printDirect');
            Route::get(
                '/download-pdf/{id}',
                [BulletinController::class, 'downloadPdf']
            )->name('downloadPdf');

            Route::get(
                '/download-direct-png',
                [BulletinController::class, 'downloadDirectPng']
            )->name('downloadDirectPng');

            Route::get(
                '/download-direct-pdf',
                [BulletinController::class, 'downloadDirectPdf']
            )->name('downloadDirectPdf');
        });

    /*
    |--------------------------------------------------------------------------
    | CONFIGURATION
    |--------------------------------------------------------------------------
    */

    Route::middleware(['admin.only'])
    ->prefix('config')
    ->name('config.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
    |       GESTION DES RÔLES
        |--------------------------------------------------------------------------
        */

        Route::middleware(['admin.only'])->group(function () {
            Route::get('/roles', [RoleController::class, 'index'])
                ->name('roles.index');

            Route::get('/roles/create', [RoleController::class, 'create'])
                ->name('roles.create');

            Route::post('/roles', [RoleController::class, 'store'])
                ->name('roles.store');

            Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
                ->name('roles.destroy');

            Route::get('/roles/{role}/permissions', [RoleController::class, 'editPermissions'])
                ->name('roles.permissions.edit');

            Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])
                ->name('roles.permissions.update');
        });

        /*
        |--------------------------------------------------------------------------
        | POINTAGE
        |--------------------------------------------------------------------------
        */

        Route::get('/pointage', [ConfigController::class, 'pointage'])
            ->name('pointage');

        /*
|--------------------------------------------------------------------------
| POINTAGE
|--------------------------------------------------------------------------
*/

        Route::get('/pointage', [ConfigController::class, 'pointage'])
            ->name('pointage');

        Route::put('/pointage', [ConfigController::class, 'updatePointage'])
            ->name('pointage.update');

        /*
|--------------------------------------------------------------------------
| ANNÉE SCOLAIRE
|--------------------------------------------------------------------------
*/

        Route::resource(
            'annees-scolaires',
            AnneeScolaireController::class
        )->parameters([
            'annees-scolaires' => 'anneeScolaire',
        ]);

        Route::patch(
            'annees-scolaires/{anneeScolaire}/activer',
            [AnneeScolaireController::class, 'activer']
        )->name('annees-scolaires.activer');

        /*
        |--------------------------------------------------------------------------
        | DROITS
        |--------------------------------------------------------------------------
        */

        Route::get('/droit-inscription', [ConfigController::class, 'droitInscription'])
            ->name('droit.inscription');

        Route::get('/droit-reinscription', [ConfigController::class, 'droitReinscription'])
            ->name('droit.reinscription');

        /*
        |--------------------------------------------------------------------------
        | MODE DE PAIEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/mode-paiement', [ConfigController::class, 'modePaiement'])
            ->name('mode.paiement');

        Route::put('/mode-paiement', [ConfigController::class, 'updateModePaiement'])
            ->name('mode.paiement.update');

        /*
        |--------------------------------------------------------------------------
        | ÉCOLES
        |--------------------------------------------------------------------------
        */

        Route::get('/ecoles', [ConfigController::class, 'ecoles'])
            ->name('ecoles');

        /*
        |--------------------------------------------------------------------------
        | TEST NIVEAU
        |--------------------------------------------------------------------------
        */

        Route::get('/test-niveau', [ConfigController::class, 'testNiveau'])
            ->name('test.niveau');

        /*
        |--------------------------------------------------------------------------
        | FRAIS DIVERS
        |--------------------------------------------------------------------------
        */

        Route::get('/frais-divers', [ConfigController::class, 'fraisDivers'])
            ->name('frais.divers');

        /*
        |--------------------------------------------------------------------------
        | PARASCOLAIRES
        |--------------------------------------------------------------------------
        */

        Route::get('/parascolaires', [ConfigController::class, 'parascolaires'])
            ->name('parascolaires');

        Route::post('/parascolaires', [ConfigController::class, 'parascolairesStore'])
            ->name('parascolaires.store');

        Route::get('/parascolaires/{activite}/edit', [ConfigController::class, 'parascolairesEdit'])
            ->name('parascolaires.edit');

        Route::put('/parascolaires/{activite}', [ConfigController::class, 'parascolairesUpdate'])
            ->name('parascolaires.update');

        Route::patch('/parascolaires/{activite}/toggle', [ConfigController::class, 'parascolairesToggle'])
            ->name('parascolaires.toggle');

        Route::delete('/parascolaires/{activite}', [ConfigController::class, 'parascolairesDestroy'])
            ->name('parascolaires.destroy');

        /*
        |--------------------------------------------------------------------------
        | CLASSEMENT DES MATIÈRES
        |--------------------------------------------------------------------------
        */

        Route::get('/rang-matiere', [RangMatiereController::class, 'index'])
            ->name('rang_matiere');

        Route::post('/rang-matiere/deplacer', [RangMatiereController::class, 'deplacer'])
            ->name('rang_matiere.deplacer');

        Route::post('/rang-matiere/enregistrer', [RangMatiereController::class, 'enregistrer'])
            ->name('rang_matiere.enregistrer');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/


require __DIR__ . '/auth.php';

// ESPACE PARENT
Route::middleware(['auth', 'parent'])
    ->prefix('espace-parent')
    ->name('parent.')
    ->controller(EspaceParentController::class)
    ->group(function () {
        Route::get('/notes-bulletins', 'notes')
    ->name('notes.index');

        Route::get('/dashboard', 'dashboard')
            ->name('dashboard');

        Route::get('/mes-enfants', 'mesEnfants')
            ->name('enfants');

        Route::get('/emploi-temps', 'emploiTemps')
            ->name('emploi-temps');
            Route::get('/frais', 'frais')
    ->name('frais');
    Route::get('/historique-paiements', 'historiquePaiements')
    ->name('paiements.historique');
    
            });

// ACTIVITÉS PARASCOLAIRES
Route::middleware(['auth', 'parent'])
    ->prefix('espace-parent/activites')
    ->name('parent.activites.')
    ->controller(EspaceParentActiviteController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');
    });
    // ======================================================
// ADMINISTRATION - ANNONCES ET COMMUNICATIONS
// ======================================================

Route::middleware(['auth', 'admin.only'])
    ->prefix('admin')
    ->group(function () {

        Route::resource('annonces', AnnonceController::class)
            ->except(['show']);

        Route::post('/annonces/{annonce}/publier',
            [AnnonceController::class, 'publier'])
            ->name('annonces.publier');

        Route::post('/annonces/{annonce}/depublier',
            [AnnonceController::class, 'depublier'])
            ->name('annonces.depublier');
    });
    // ======================================================
// ESPACE PARENT - ANNONCES EN LECTURE SEULE
// ======================================================

Route::middleware(['auth', 'parent'])
    ->prefix('espace-parent/annonces')
    ->name('parent.annonces.')
    ->controller(EspaceParentAnnonceController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/{annonce}', 'show')
            ->name('show');
    });
// ======================================================
// MESSAGERIE PARENT
// ======================================================

Route::middleware(['auth', 'parent'])
    ->prefix('espace-parent/messagerie')
    ->name('parent.messagerie.')
    ->controller(EspaceParentMessagerieController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::post('/envoyer', 'envoyer')->name('envoyer');
    });


// ======================================================
// MESSAGERIE ADMINISTRATEUR
// ======================================================

Route::middleware(['auth', 'admin.only'])
    ->prefix('admin/messagerie')
    ->name('admin.messagerie.')
    ->controller(AdminMessagerieController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/{conversation}', 'show')->name('show');

        Route::post('/{conversation}/repondre', 'repondre')
            ->name('repondre');
    });