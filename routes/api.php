<?php

use App\Http\Controllers\Exploitation\Reception\ClientsController;
use App\Http\Controllers\Exploitation\Reception\ContratController;
use App\Http\Controllers\Exploitation\Reception\ContratsAnnexesController;
use App\Http\Controllers\Exploitation\Reception\ContratsEmplacementsController;
use App\Http\Controllers\Exploitation\Reception\OrdonnancementController;
use App\Http\Controllers\Exploitation\Reception\PersonnesController;
use App\Http\Controllers\Exploitation\Reception\ProspectsController;
use App\Http\Controllers\Exploitation\Reception\TypePersonnesController;
use App\Http\Controllers\Finance\ChequeController;
use App\Http\Controllers\Finance\Facture\FactureAnnexeController;
use App\Http\Controllers\Finance\Facture\FactureController;
use App\Http\Controllers\Finance\Facture\FactureEquipementController;
use App\Http\Controllers\Finance\Facture\FactureInitialeController;
use App\Http\Controllers\Finance\Facture\FactureLoyerController;
use App\Http\Controllers\Finance\PaiementLigneController;
use App\Http\Controllers\Parametre\Architecture\AbonnementsController;
use App\Http\Controllers\Parametre\Architecture\EmplacementsController;
use App\Http\Controllers\Parametre\Architecture\EquipementsController;
use App\Http\Controllers\Parametre\Architecture\NiveauxController;
use App\Http\Controllers\Parametre\Architecture\PavillonsController;
use App\Http\Controllers\Parametre\Architecture\ServiceAnnexesController;
use App\Http\Controllers\Parametre\Architecture\SitesController;
use App\Http\Controllers\Parametre\Architecture\TypeEmplacementsController;
use App\Http\Controllers\Parametre\Architecture\TypeEquipementsController;
use App\Http\Controllers\Parametre\Architecture\ValidationAbonnementController;
use App\Http\Controllers\Parametre\Architecture\ZonesController;
use App\Http\Controllers\Parametre\AuthController;
use App\Http\Controllers\Parametre\PermissionsController;
use App\Http\Controllers\Parametre\RolesController;
use App\Http\Controllers\Parametre\Template\TermesContratsAnnexesController;
use App\Http\Controllers\Parametre\Template\TermesContratsEmplacementsController;
use App\Http\Controllers\Parametre\UtilisateursController;
use App\Models\Architecture\ValidationAbonnement;
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
    Route::controller(UtilisateursController::class)->prefix('users')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::post('/profile', 'profile');
        Route::post('/notifications', 'notifications');
        Route::post('/autoriser', 'autoriserByRole');
        Route::post('/security', 'security');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(RolesController::class)->prefix('roles')->group(function () {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
    });
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionsController::class, 'all']);
        Route::get('/show/{id}', [PermissionsController::class, 'show']);
    });
    Route::controller(SitesController::class)->prefix('marches')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::post('/push', 'push');
        Route::get('/structure', 'structure');
        Route::get('{id}', 'show');
        Route::get('/structure/{id}', 'showStructure');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(PavillonsController::class)->prefix('pavillons')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::get('/marche/{id}', 'getByMarche');
        Route::post('/store', 'store');
        Route::post('/push', 'push');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(NiveauxController::class)->prefix('niveaux')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::post('/push', 'push');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(ZonesController::class)->prefix('zones')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::post('/push', 'push');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(EmplacementsController::class)->prefix('emplacements')->group(function () {
        Route::get('/', 'all');
        Route::get('/equipables', 'equipables');
        Route::get('/trashed', 'trashed');
        Route::get('/rental/{date}', 'getRentalbyMonth');
        Route::get('/marche/{id}', 'getByMarche');
        Route::get('/marche/gears/{id}', 'getByMarcheWithGearsAndContracts');
        Route::get('/marche/unlinked/{id}', 'getUnlinkedByMarche');
        Route::get('/marche/free/{id}', 'getFreeByMarche');
        Route::get('/marche/busy/{id}', 'getBusyByMarche');
        Route::post('/store', 'store');
        Route::post('/push', 'push');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(AbonnementsController::class)->prefix('abonnements')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::post('/abonner', 'insert');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('finished/{id}', 'finish');
        Route::patch('/restore/{id}', 'restore');
        Route::get('/indexing/{id}', 'lastIndex');
    });
    Route::controller(ServiceAnnexesController::class)->prefix('annexes')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::get('/marche/{id}', 'getByMarche');
        Route::post('/store', 'store');
        Route::patch('/restore/{id}', 'restore');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
    });
    Route::controller(EquipementsController::class)->prefix('equipements')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::get('/unlinkedsubscribed', 'getUnlinkedsubscribed');
        Route::get('{id}', 'show');
        Route::get('/type/{id}/emplacement/{emplacement}/site/{site}', 'getGearsForContratView');
        Route::post('/store', 'store');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(TypeEquipementsController::class)->prefix('equipement/types')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(TypeEmplacementsController::class)->prefix('emplacement/types')->group(function () {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::prefix('termes')->group(function () {
        Route::controller(TermesContratsAnnexesController::class)->prefix('annexes')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::get('/pdf/{id}', 'pdf');
            Route::delete('{id}', 'trash');
            Route::put('{id}', 'update');
            Route::patch('/restore/{id}', 'restore');
        });
        Route::controller(TermesContratsEmplacementsController::class)->prefix('emplacements')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::get('/pdf/{id}', 'pdf');
            Route::delete('{id}', 'trash');
            Route::put('{id}', 'update');
            Route::patch('/restore/{id}', 'restore');
        });
    });
    Route::controller(ValidationAbonnementController::class)->prefix('validations/abonnement')->group(function () {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
    });
});

Route::middleware('auth:sanctum')->prefix('exploitations')->group(function () {
    Route::prefix('receptions')->group(function () {
        Route::controller(PersonnesController::class)->prefix('personnes')->group(function () {
            Route::get('/', 'all');
            Route::post('/store', 'store');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
        Route::controller(ProspectsController::class)->prefix('prospects')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::patch('/restore/{id}', 'restore');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
        });
        Route::controller(ClientsController::class)->prefix('clients')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::patch('/restore/{id}', 'restore');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
        });
        Route::controller(OrdonnancementController::class)->prefix('ordonnancements')->group(function () {
            Route::get('/', 'all');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
        });
        Route::prefix('contrats')->group(function () {
            Route::get('/', [ContratController::class, 'all']);
            Route::get('/scheduling', [ContratController::class, 'schedulableContrats']);
            Route::controller(ContratsAnnexesController::class)->prefix('annexes')->group(function () {
                Route::get('/', 'all');
                Route::get('/trashed', 'trashed');
                Route::post('/store', 'store');
                Route::get('{id}', 'show');
                Route::put('{id}', 'update');
                Route::patch('/restore/{id}', 'restore');
                Route::patch('/schedule/{id}', 'toSchedule');
                Route::delete('{id}', 'trash');
            });
            Route::controller(ContratsEmplacementsController::class)->prefix('emplacements')->group(function () {
                Route::get('/', 'all');
                Route::get('/trashed', 'trashed');
                Route::post('/store', 'store');
                Route::get('{id}', 'show');
                Route::get('/details/{id}', 'details');
                Route::put('{id}', 'update');
                Route::patch('/restore/{id}', 'restore');
                Route::patch('/schedule/{id}', 'toSchedule');
                Route::delete('{id}', 'trash');
            });
        });
        Route::controller(TypePersonnesController::class)->prefix('personne/types')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::get('/marche/{id}', 'getByMarche');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
    });
});
Route::middleware('auth:sanctum')->prefix('finances')->group(function () {
    Route::prefix('factures')->group(function () {
        Route::get('/', [FactureController::class, 'all']);
        Route::get('/contrat/{id}', [FactureController::class, 'getByContrat']);
        Route::controller(FactureAnnexeController::class)->prefix('annexes')->group(function () {
            Route::get('/', 'all');
            Route::post('/store', 'store');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
        Route::controller(FactureLoyerController::class)->prefix('loyers')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
        Route::controller(FactureInitialeController::class)->prefix('initiales')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
        Route::controller(FactureEquipementController::class)->prefix('equipements')->group(function () {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
    });
    Route::controller(ChequeController::class)->prefix('cheques')->group(function () {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('/marche/{id}', 'getByMarche');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(PaiementLigneController::class)->prefix('paiementsLignes')->group(function () {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('/marche/{id}', 'getByMarche');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
});
