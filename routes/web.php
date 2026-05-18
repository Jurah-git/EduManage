<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\ConfigController;

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\EleveController;

use App\Http\Controllers\CahierTexteController;
use App\Http\Controllers\EmploiTempsController;

use App\Http\Controllers\LivreController;
use App\Http\Controllers\BibliothequeController;

use App\Http\Controllers\ParentController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\PeriodeController;

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

    Route::get('/users/create', [ConfigController::class, 'usersCreate'])
        ->name('config.users.create');

    Route::get('/users', [ConfigController::class, 'usersList'])
        ->name('config.users.list');

    Route::post('/users/store', [ConfigController::class, 'usersStore'])
        ->name('config.users.store');

    Route::delete('/users/{user}', [ConfigController::class, 'usersDelete'])
        ->name('config.users.delete');

    /*
    |--------------------------------------------------------------------------
    | CLASSES
    |--------------------------------------------------------------------------
    */

    Route::resource('classes', ClasseController::class)
        ->parameters([
            'classes' => 'classe'
        ]);

    /*
    |--------------------------------------------------------------------------
    | MATIÈRES
    |--------------------------------------------------------------------------
    */

    Route::resource('matieres', MatiereController::class);

    /*
    |--------------------------------------------------------------------------
    | ÉLÈVES
    |--------------------------------------------------------------------------
    */

    Route::resource('eleves', EleveController::class)
        ->parameters([
            'eleves' => 'eleve'
        ]);

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

    Route::resource('emploi', EmploiTempsController::class);

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
    | PARENTS
    |--------------------------------------------------------------------------
    */

    Route::get('/parents', [ParentController::class, 'index'])
        ->name('parents.index');

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

    Route::prefix('bulletin')->name('bulletin.')->group(function () {

        Route::get('/saisie', [BulletinController::class, 'saisie'])->name('saisie');

        Route::get('/eleve/{id}', [BulletinController::class, 'getEleve'])->name('eleve');

        Route::post('/store', [BulletinController::class, 'store'])->name('store');

        
    });

    /*
    |--------------------------------------------------------------------------
    | CONFIGURATION
    |--------------------------------------------------------------------------
    */

    Route::prefix('config')->name('config.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | UTILISATEURS
        |--------------------------------------------------------------------------
        */

        Route::get('/users/create', [ConfigController::class, 'usersCreate'])
            ->name('users.create');

        Route::get('/users', [ConfigController::class, 'usersList'])
            ->name('users.list');

        /*
        |--------------------------------------------------------------------------
        | POINTAGE
        |--------------------------------------------------------------------------
        */

        Route::get('/pointage', [ConfigController::class, 'pointage'])
            ->name('pointage');

        /*
        |--------------------------------------------------------------------------
        | ANNÉE SCOLAIRE
        |--------------------------------------------------------------------------
        */

        Route::get('/annee/create', [ConfigController::class, 'anneeCreate'])
            ->name('annee.create');

        Route::get('/annee/current', [ConfigController::class, 'anneeCurrent'])
            ->name('annee.current');

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

        /*
        |--------------------------------------------------------------------------
        | RANG MATIÈRE
        |--------------------------------------------------------------------------
        */

        Route::get('/rang-matiere', [ConfigController::class, 'rangMatiere'])
            ->name('rang.matiere');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
