<?php

use App\Http\Controllers\Exploitation\Reception\ClientsController;
use App\Http\Controllers\Exploitation\Reception\ContratsAnnexesController;
use App\Http\Controllers\Exploitation\Reception\ContratsEmplacementsController;
use App\Http\Controllers\Exploitation\Reception\PersonnesController;
use App\Http\Controllers\Exploitation\Reception\ProspectsController;
use App\Http\Controllers\Exploitation\Reception\TypePersonnesController;
use App\Http\Controllers\Parametre\Architecture\AbonnementsController;
use App\Http\Controllers\Parametre\Architecture\EmplacementsController;
use App\Http\Controllers\Parametre\Architecture\EquipementsController;
use App\Http\Controllers\Parametre\Architecture\NiveauxController;
use App\Http\Controllers\Parametre\Architecture\PavillonsController;
use App\Http\Controllers\Parametre\Architecture\ServiceAnnexesController;
use App\Http\Controllers\Parametre\Architecture\SitesController;
use App\Http\Controllers\Parametre\Architecture\TypeEmplacementsController;
use App\Http\Controllers\Parametre\Architecture\TypeEquipementsController;
use App\Http\Controllers\Parametre\Architecture\ZonesController;
use App\Http\Controllers\Parametre\AuthController;
use App\Http\Controllers\Parametre\PermissionsController;
use App\Http\Controllers\Parametre\RolesController;
use App\Http\Controllers\Parametre\Template\TermesContratsAnnexesController;
use App\Http\Controllers\Parametre\Template\TermesContratsEmplacementsController;
use App\Http\Controllers\Parametre\UtilisateursController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('user', [AuthController::class, 'me']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->prefix('parametres')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UtilisateursController::class, 'all']);
        Route::get('/trashed', [UtilisateursController::class, 'trashed']);
        Route::post('/store', [UtilisateursController::class, 'store']);
        Route::post('/profile', [UtilisateursController::class, 'profile']);
        Route::post('/notifications', [UtilisateursController::class, 'notifications']);
        Route::post('/autoriser', [UtilisateursController::class, 'autoriserByRole']);
        Route::post('/security', [UtilisateursController::class, 'security']);
        Route::get('{id}', [UtilisateursController::class, 'show']);
        Route::delete('{id}', [UtilisateursController::class, 'trash']);
        Route::get('/restore/{id}', [UtilisateursController::class, 'restore']);
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'all']);
        Route::post('/store', [RolesController::class, 'store']);
        Route::get('{id}', [RolesController::class, 'show']);
        Route::put('{id}', [RolesController::class, 'update']);
    });
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionsController::class, 'all']);
        Route::get('/show/{id}', [PermissionsController::class, 'show']);
    });
    Route::prefix('marches')->group(function () {
        Route::get('/', [SitesController::class, 'all']);
        Route::get('/trashed', [SitesController::class, 'trashed']);
        Route::post('/store', [SitesController::class, 'store']);
        Route::post('/push', [SitesController::class, 'push']);
        Route::get('/structure', [SitesController::class, 'structure']);
        Route::get('{id}', [SitesController::class, 'show']);
        Route::get('/structure/{id}', [SitesController::class, 'showStructure']);
        Route::delete('{id}', [SitesController::class, 'trash']);
        Route::put('{id}', [SitesController::class, 'update']);
        Route::get('/restore/{id}', [SitesController::class, 'restore']);
    });
    Route::prefix('pavillons')->group(function () {
        Route::get('/', [PavillonsController::class, 'all']);
        Route::get('/trashed', [PavillonsController::class, 'trashed']);
        Route::get('/marche/{id}', [PavillonsController::class, 'getByMarche']);
        Route::post('/store', [PavillonsController::class, 'store']);
        Route::post('/push', [PavillonsController::class, 'push']);
        Route::get('{id}', [PavillonsController::class, 'show']);
        Route::put('{id}', [PavillonsController::class, 'update']);
        Route::delete('{id}', [PavillonsController::class, 'trash']);
        Route::get('/restore/{id}', [PavillonsController::class, 'restore']);
    });
    Route::prefix('niveaux')->group(function () {
        Route::get('/', [NiveauxController::class, 'all']);
        Route::get('/trashed', [NiveauxController::class, 'trashed']);
        Route::post('/store', [NiveauxController::class, 'store']);
        Route::post('/push', [NiveauxController::class, 'push']);
        Route::get('{id}', [NiveauxController::class, 'show']);
        Route::delete('{id}', [NiveauxController::class, 'trash']);
        Route::put('{id}', [NiveauxController::class, 'update']);
        Route::get('/restore/{id}', [NiveauxController::class, 'restore']);
    });
    Route::prefix('zones')->group(function () {
        Route::get('/', [ZonesController::class, 'all']);
        Route::get('/trashed', [ZonesController::class, 'trashed']);
        Route::post('/store', [ZonesController::class, 'store']);
        Route::post('/push', [ZonesController::class, 'push']);
        Route::get('{id}', [ZonesController::class, 'show']);
        Route::delete('{id}', [ZonesController::class, 'trash']);
        Route::put('{id}', [ZonesController::class, 'update']);
        Route::get('/restore/{id}', [ZonesController::class, 'restore']);
    });
    Route::prefix('emplacements')->group(function () {
        Route::get('/', [EmplacementsController::class, 'all']);
        Route::get('/trashed', [EmplacementsController::class, 'trashed']);
        Route::get('/marche/{id}', [EmplacementsController::class, 'getByMarche']);
        Route::post('/store', [EmplacementsController::class, 'store']);
        Route::post('/push', [EmplacementsController::class, 'push']);
        Route::get('{id}', [EmplacementsController::class, 'show']);
        Route::delete('{id}', [EmplacementsController::class, 'trash']);
        Route::put('{id}', [EmplacementsController::class, 'update']);
        Route::get('/restore/{id}', [EmplacementsController::class, 'restore']);
    });
    Route::prefix('abonnements')->group(function () {
        Route::get('/', [AbonnementsController::class, 'all']);
        Route::get('/trashed', [AbonnementsController::class, 'trashed']);
        Route::post('/store', [AbonnementsController::class, 'store']);
        Route::get('{id}', [AbonnementsController::class, 'show']);
        Route::delete('{id}', [AbonnementsController::class, 'trash']);
        Route::put('{id}', [AbonnementsController::class, 'update']);
        Route::put('finished/{id}', [AbonnementsController::class, 'finish']);
        Route::get('/restore/{id}', [AbonnementsController::class, 'restore']);
        Route::get('/indexing/{id}', [AbonnementsController::class, 'lastIndex']);
    });
    Route::prefix('annexes')->group(function () {
        Route::get('/', [ServiceAnnexesController::class, 'all']);
        Route::get('/trashed', [ServiceAnnexesController::class, 'trashed']);
        Route::get('/marche/{id}', [ServiceAnnexesController::class, 'getByMarche']);
        Route::post('/store', [ServiceAnnexesController::class, 'store']);
        Route::get('{id}', [ServiceAnnexesController::class, 'show']);
        Route::delete('{id}', [ServiceAnnexesController::class, 'trash']);
        Route::put('{id}', [ServiceAnnexesController::class, 'update']);
        Route::get('/restore/{id}', [ServiceAnnexesController::class, 'restore']);
    });
    Route::prefix('equipements')->group(function () {
        Route::get('/', [EquipementsController::class, 'all']);
        Route::get('/trashed', [EquipementsController::class, 'trashed']);
        Route::post('/store', [EquipementsController::class, 'store']);
        Route::get('{id}', [EquipementsController::class, 'show']);
        Route::delete('{id}', [EquipementsController::class, 'trash']);
        Route::put('{id}', [EquipementsController::class, 'update']);
        Route::get('/restore/{id}', [EquipementsController::class, 'restore']);
    });
    Route::prefix('equipement/types')->group(function () {
        Route::get('/', [TypeEquipementsController::class, 'all']);
        Route::get('/trashed', [TypeEquipementsController::class, 'trashed']);
        Route::post('/store', [TypeEquipementsController::class, 'store']);
        Route::get('{id}', [TypeEquipementsController::class, 'show']);
        Route::delete('{id}', [TypeEquipementsController::class, 'trash']);
        Route::put('{id}', [TypeEquipementsController::class, 'update']);
        Route::get('/restore/{id}', [TypeEquipementsController::class, 'restore']);
    });
    Route::prefix('emplacement/types')->group(function () {
        Route::get('/', [TypeEmplacementsController::class, 'all']);
        Route::get('/trashed', [TypeEmplacementsController::class, 'trashed']);
        Route::post('/store', [TypeEmplacementsController::class, 'store']);
        Route::get('{id}', [TypeEmplacementsController::class, 'show']);
        Route::delete('{id}', [TypeEmplacementsController::class, 'trash']);
        Route::put('{id}', [TypeEmplacementsController::class, 'update']);
        Route::get('/restore/{id}', [TypeEmplacementsController::class, 'restore']);
    });
    Route::prefix('termes')->group(function () {
        Route::prefix('annexes')->group(function () {
            Route::get('/', [TermesContratsAnnexesController::class, 'allAnnexes']);
            Route::get('/trashed', [TermesContratsAnnexesController::class, 'trashedAnnexes']);
            Route::post('/store', [TermesContratsAnnexesController::class, 'store']);
            Route::get('{id}', [TermesContratsAnnexesController::class, 'show']);
            Route::delete('{id}', [TermesContratsAnnexesController::class, 'trash']);
            Route::put('{id}', [TermesContratsAnnexesController::class, 'update']);
            Route::get('/restore/{id}', [TermesContratsAnnexesController::class, 'restore']);
        });
        Route::prefix('emplacements')->group(function () {
            Route::get('/', [TermesContratsEmplacementsController::class, 'allBails']);
            Route::get('/trashed', [TermesContratsEmplacementsController::class, 'trashedBails']);
            Route::post('/store', [TermesContratsEmplacementsController::class, 'store']);
            Route::get('{id}', [TermesContratsEmplacementsController::class, 'show']);
            Route::delete('{id}', [TermesContratsEmplacementsController::class, 'trash']);
            Route::put('{id}', [TermesContratsEmplacementsController::class, 'update']);
            Route::get('/restore/{id}', [TermesContratsEmplacementsController::class, 'restore']);
        });
    });

});

Route::middleware('auth:sanctum')->prefix('exploitations')->group(function () {
    Route::prefix('receptions')->group(function () {
        Route::prefix('personnes')->group(function () {
            Route::get('/', [PersonnesController::class, 'leadsAndCustomers']);
            Route::post('/store', [PersonnesController::class, 'store']);
            Route::get('/marche/{id}', [PersonnesController::class, 'getByMarche']);
            Route::get('{id}', [PersonnesController::class, 'show']);
            Route::put('{id}', [PersonnesController::class, 'update']);
            Route::delete('{id}', [PersonnesController::class, 'trash']);
            Route::get('/restore/{id}', [PersonnesController::class, 'restore']);
        });
        Route::prefix('prospects')->group(function () {
            Route::get('/', [ProspectsController::class, 'all']);
            Route::get('/trashed', [ProspectsController::class, 'trashed']);
            Route::post('/store', [ProspectsController::class, 'store']);
            Route::get('{id}', [ProspectsController::class, 'show']);
            Route::put('{id}', [ProspectsController::class, 'update']);
            Route::delete('{id}', [ProspectsController::class, 'trash']);
            Route::get('/restore/{id}', [ProspectsController::class, 'restore']);
        });
        Route::prefix('clients')->group(function () {
            Route::get('/', [ClientsController::class, 'all']);
            Route::get('/trashed', [ClientsController::class, 'trashed']);
            Route::post('/store', [ClientsController::class, 'store']);
            Route::get('{id}', [ClientsController::class, 'show']);
            Route::put('{id}', [ClientsController::class, 'update']);
            Route::delete('{id}', [ClientsController::class, 'trash']);
            Route::get('/restore/{id}', [ClientsController::class, 'restore']);
        });
        Route::prefix('contrats')->group(function () {
            Route::prefix('annexes')->group(function () {
                Route::get('/', [ContratsAnnexesController::class, 'all']);
                Route::get('/trashed', [ContratsAnnexesController::class, 'trashed']);
                Route::post('/store', [ContratsAnnexesController::class, 'store']);
                Route::get('{id}', [ContratsAnnexesController::class, 'show']);
                Route::put('{id}', [ContratsAnnexesController::class, 'update']);
                Route::delete('{id}', [ContratsAnnexesController::class, 'trash']);
                Route::get('/restore/{id}', [ContratsAnnexesController::class, 'restore']);
            });
            Route::prefix('emplacements')->group(function () {
                Route::get('/', [ContratsEmplacementsController::class, 'all']);
                Route::get('/trashed', [ContratsEmplacementsController::class, 'trashed']);
                Route::post('/store', [ContratsEmplacementsController::class, 'store']);
                Route::get('{id}', [ContratsEmplacementsController::class, 'show']);
                Route::put('{id}', [ContratsEmplacementsController::class, 'update']);
                Route::delete('{id}', [ContratsEmplacementsController::class, 'trash']);
                Route::get('/restore/{id}', [ContratsEmplacementsController::class, 'restore']);
            });
        });
        Route::prefix('personne/types')->group(function () {
            Route::get('/', [TypePersonnesController::class, 'all']);
            Route::get('/trashed', [TypePersonnesController::class, 'trashed']);
            Route::get('/marche/{id}', [TypePersonnesController::class, 'getByMarche']);
            Route::post('/store', [TypePersonnesController::class, 'store']);
            Route::get('{id}', [TypePersonnesController::class, 'show']);
            Route::put('{id}', [TypePersonnesController::class, 'update']);
            Route::delete('{id}', [TypePersonnesController::class, 'trash']);
            Route::get('/restore/{id}', [TypePersonnesController::class, 'restore']);
        });
    });
});
