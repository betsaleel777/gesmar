<?php

use App\Http\Controllers\Bordereau\BordereauController;
use App\Http\Controllers\Bordereau\CollecteController;
use App\Http\Controllers\Bordereau\CommercialController;
use App\Http\Controllers\Caisse\BanqueController;
use App\Http\Controllers\Caisse\CaissierController;
use App\Http\Controllers\Caisse\CompteController;
use App\Http\Controllers\Caisse\EncaissementController;
use App\Http\Controllers\Caisse\FermetureController;
use App\Http\Controllers\Caisse\OuvertureController;
use App\Http\Controllers\Decisionel\DashboardReceptionController;
use App\Http\Controllers\Exploitation\Maintenance\ReparationController;
use App\Http\Controllers\Exploitation\Maintenance\TechnicienController;
use App\Http\Controllers\Exploitation\Reception\ClientsController;
use App\Http\Controllers\Exploitation\Reception\ContratController;
use App\Http\Controllers\Exploitation\Reception\ContratsAnnexesController;
use App\Http\Controllers\Exploitation\Reception\ContratsEmplacementsController;
use App\Http\Controllers\Exploitation\Reception\OrdonnancementController;
use App\Http\Controllers\Exploitation\Reception\PersonnesController;
use App\Http\Controllers\Exploitation\Reception\ProspectsController;
use App\Http\Controllers\Exploitation\Reception\TypePersonnesController;
use App\Http\Controllers\FileDownloadManager;
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
use App\Http\Controllers\Parametre\Caisse\GuichetController;
use App\Http\Controllers\Parametre\PermissionsController;
use App\Http\Controllers\Parametre\RolesController;
use App\Http\Controllers\Parametre\SocieteController;
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

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'me']);
Route::middleware('auth:sanctum')->get('/media', [FileDownloadManager::class, 'index']);
Route::middleware('auth:sanctum')->controller(AuthController::class)->group(function (): void {
    Route::post('deconnecter', 'deconnecter');
    Route::post('logout', 'logout');
});
Route::middleware('auth:sanctum')->prefix('parametres')->group(function (): void {
    Route::controller(UtilisateursController::class)->prefix('users')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/uncommercials', 'uncommercials');
        Route::get('/uncashiers', 'uncashiers');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::post('/profile', 'profile');
        Route::post('/notifications', 'notifications');
        Route::post('/autoriser', 'autoriserByRole');
        Route::post('/security', 'security');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
        Route::post('attribuer-role', 'attribuer');
    });
    Route::controller(RolesController::class)->prefix('roles')->group(function (): void {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
    });
    Route::prefix('permissions')->group(function (): void {
        Route::get('/', [PermissionsController::class, 'all']);
        Route::get('{id}', [PermissionsController::class, 'getByRole']);
        Route::get('/show/{id}', [PermissionsController::class, 'show']);
    });
    Route::controller(SitesController::class)->prefix('marches')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/select', 'select');
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
    Route::controller(PavillonsController::class)->prefix('pavillons')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/select', 'search');
        Route::get('/trashed', 'trashed');
        Route::get('/marche/{id}', 'getByMarche');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(NiveauxController::class)->prefix('niveaux')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/select', 'search');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(ZonesController::class)->prefix('zones')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/select', 'search');
        Route::get('/trashed', 'trashed');
        Route::get('/zone-attribution/{id}', 'getForAttribution');
        Route::get('{id}', 'show');
        Route::get('/marche/{id}', 'getByMarche');
        Route::post('/store', 'store');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(EmplacementsController::class)->prefix('emplacements')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/for-subscribe/{id}', 'getForSubscribeView');
        Route::get('/select', 'select');
        Route::get('/simple-select', 'simpleSelect');
        Route::get('/autos', 'allAuto');
        Route::get('/autos/site', 'allAutoBySite');
        Route::get('/equipables', 'equipables');
        Route::get('/trashed', 'trashed');
        Route::get('/rental/{date}', 'getRentalbyMonthLoyer');
        Route::get('/marche/{id}', 'getByMarche');
        Route::get('/free/by-site-personne', 'getFreeByMarchePersonne');
        Route::get('/marche-select/{id}', 'getByMarcheSelect');
        Route::get('/marche/gears/{id}', 'getByMarcheWithGearsAndContracts');
        Route::get('/marche/unlinked/{id}', 'getUnlinkedByMarche');
        Route::get('/marche/free/{id}', 'getFreeByMarche');
        Route::get('/marche/busy/{id}', 'getBusyByMarche');
        Route::get('zones', 'getByZones');
        Route::post('/store', 'store');
        Route::post('/push', 'push');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(AbonnementsController::class)->prefix('abonnements')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/paginate', 'getPaginate');
        Route::get('/search/{search}/paginate', 'getSearch');
        Route::get('/trashed', 'trashed');
        Route::get('/rental-gear/{date}', 'getRentalbyMonthGear');
        Route::post('/store', 'store');
        Route::post('/abonner', 'insert');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('finished/{id}', 'finish');
        Route::patch('/restore/{id}', 'restore');
        Route::get('/indexing/{id}', 'lastIndex');
    });
    Route::controller(ServiceAnnexesController::class)->prefix('annexes')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::get('/marche/{id}', 'getByMarche');
        Route::post('/store', 'store');
        Route::patch('/restore/{id}', 'restore');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
    });
    Route::controller(EquipementsController::class)->prefix('equipements')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/paginate', 'getPaginate');
        Route::get('/search/{search}/paginate', 'getSearch');
        Route::get('/trashed', 'trashed');
        Route::get('/unlinkedsubscribed', 'getUnlinkedsubscribed');
        Route::get('{id}', 'show');
        Route::get('/type/{id}/emplacement/{emplacement}/site/{site}', 'getGearsForContratView');
        Route::post('/store', 'store');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(TypeEquipementsController::class)->prefix('equipement/types')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::get('/site', 'getBySite');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(TypeEmplacementsController::class)->prefix('emplacement/types')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'trash');
        Route::put('{id}', 'update');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(SocieteController::class)->prefix('societes')->group(function (): void {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::put('{id}', 'update');
        Route::get('{id}', 'show');
    });
    Route::prefix('termes')->group(function (): void {
        Route::controller(TermesContratsAnnexesController::class)->prefix('annexes')->group(function (): void {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::get('/pdf/{id}', 'pdf');
            Route::delete('{id}', 'trash');
            Route::put('{id}', 'update');
            Route::patch('/restore/{id}', 'restore');
        });
        Route::controller(TermesContratsEmplacementsController::class)->prefix('emplacements')->group(function (): void {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('/pdf/{id}', 'pdf');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
    });
    Route::controller(ValidationAbonnementController::class)->prefix('validations/abonnement')->group(function (): void {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
    });
    Route::controller(GuichetController::class)->prefix('guichets')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::put('{id}', 'update');
        Route::get('{id}', 'show');
    });
    Route::controller(CaissierController::class)->prefix('caissiers')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/free', 'getFree');
        Route::get('/busy', 'getBusy');
        Route::get('/half-free', 'getHalfFree');
        Route::get('/check-free', 'checkFree');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::post('/attribuer', 'attribuate');
        Route::delete('/desattribuer/{id}', 'desattribuate');
        Route::put('{id}', 'update');
        Route::get('{id}', 'show');
    });
    Route::controller(CompteController::class)->prefix('comptes')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::put('{id}', 'update');
        Route::get('{id}', 'show');
    });
    Route::controller(BanqueController::class)->prefix('banques')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/trashed', 'trashed');
        Route::post('/store', 'store');
        Route::put('{id}', 'update');
        Route::get('{id}', 'show');
    });
});

Route::middleware('auth:sanctum')->prefix('exploitations')->group(function (): void {
    Route::prefix('receptions')->group(function (): void {
        Route::controller(PersonnesController::class)->prefix('personnes')->group(function (): void {
            Route::get('/', 'all');
            Route::get('/select', 'getForSelect');
            Route::post('/store', 'store');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
            Route::patch('/restore/{id}', 'restore');
        });
        Route::controller(ProspectsController::class)->prefix('prospects')->group(function (): void {
            Route::get('/', 'all');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::patch('/restore/{id}', 'restore');
            Route::patch('image-upload/{id}', 'updateImage');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
        });
        Route::controller(ClientsController::class)->prefix('clients')->group(function (): void {
            Route::get('/', 'all');
            Route::get('/paginate', 'getPaginate');
            Route::get('/search/{search}/paginate', 'getSearch');
            Route::get('/trashed', 'trashed');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::patch('/restore/{id}', 'restore');
            Route::patch('image-upload/{id}', 'updateImage');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
        });
        Route::controller(OrdonnancementController::class)->prefix('ordonnancements')->group(function (): void {
            Route::get('/', 'all');
            Route::get('/paginate', 'getPaginate');
            Route::get('/search/{search}/paginate', 'getSearch');
            Route::get('/unpaid', 'unpaids');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'trash');
        });
        Route::prefix('contrats')->group(function (): void {
            Route::get('/', [ContratController::class, 'all']);
            Route::get('/{id}', [ContratController::class, 'show']);
            Route::get('/scheduling', [ContratController::class, 'schedulableContrats']);
            Route::get('/personne/{id}', [ContratController::class, 'contratByPerson']);
            Route::controller(ContratsAnnexesController::class)->prefix('annexes')->group(function (): void {
                Route::get('/', 'all');
                Route::get('/paginate', 'getPaginate');
                Route::get('/search/{search}/paginate', 'getSearch');
                Route::get('/valides/paginate', 'getValidesPaginate');
                Route::get('/valides/search/{search}/paginate', 'getValidesSearch');
                Route::get('/valides', 'valides');
                Route::get('/trashed', 'trashed');
                Route::post('/store', 'store');
                Route::get('{id}', 'show');
                Route::put('{id}', 'update');
                Route::patch('/restore/{id}', 'restore');
                Route::patch('/schedule/{id}', 'toSchedule');
                Route::delete('{id}', 'trash');
            });
            Route::controller(ContratsEmplacementsController::class)->prefix('emplacements')->group(function (): void {
                Route::get('/', 'all');
                Route::get('/avec-equipements', 'getWithGear');
                Route::get('/paginate', 'getPaginate');
                Route::get('/search/{search}/paginate', 'getSearch');
                Route::get('/valides/paginate', 'getValidesPaginate');
                Route::get('/valides/search/{search}/paginate', 'getValidesSearch');
                Route::get('/print/{id}', 'print');
                Route::get('/valides', 'valides');
                Route::get('/trashed', 'trashed');
                Route::post('/store', 'store');
                Route::get('{id}', 'show');
                Route::get('personne/{id}', 'getByPersonne');
                Route::get('/details/{id}', 'details');
                Route::put('{id}', 'update');
                Route::patch('/restore/{id}', 'restore');
                Route::patch('/schedule/{id}', 'toSchedule');
                Route::delete('{id}', 'trash');
            });
        });
        Route::controller(TypePersonnesController::class)->prefix('personne/types')->group(function (): void {
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
    Route::prefix('maintenances')->group(function (): void {
        Route::controller(ReparationController::class)->prefix('reparations')->group(function (): void {
            Route::get('/', 'index');
            Route::get('/paginate', 'getPaginate');
            Route::get('/search/{search}/paginate', 'getSearch');
            Route::get('/paginate-trashed', 'getPaginateTrashed');
            Route::get('/search-trashed/{search}/paginate', 'getSearchTrashed');
            Route::post('/store', 'store');
            Route::get('{reparation}', 'show');
            Route::put('{reparation}', 'update');
            Route::delete('{reparation}', 'destroy');
            Route::patch('restore/{id}', 'restore');
        });
        Route::controller(TechnicienController::class)->prefix('techniciens')->group(function (): void {
            Route::get('/', 'index');
            Route::get('/paginate', 'getPaginate');
            Route::get('/search/{search}/paginate', 'getSearch');
            Route::get('/paginate-trashed', 'getPaginateTrashed');
            Route::get('/search-trashed/{search}/paginate', 'getSearchTrashed');
            Route::post('/store', 'store');
            Route::get('{technicien}', 'show');
            Route::put('{technicien}', 'update');
            Route::delete('{technicien}', 'destroy');
            Route::patch('restore/{id}', 'restore');
        });
    });
});
Route::middleware('auth:sanctum')->prefix('finances')->group(function (): void {
    Route::prefix('factures')->group(function (): void {
        Route::get('/', [FactureController::class, 'all']);
        Route::get('/soldees/paginate', [FactureController::class, 'getSoldeesPaginate']);
        Route::get('/soldees/search/{search}/paginate', [FactureController::class, 'getSoldeesSearch']);
        Route::get('/personne/{id}/paginate', [FactureController::class, 'getPersonnePaginate']);
        Route::get('/personne/{id}/search/{search}/paginate', [FactureController::class, 'getPersonneSearch']);
        Route::get('/contrat/{id}', [FactureController::class, 'getByContrat']);
        Route::controller(FactureAnnexeController::class)->prefix('annexes')->group(
            function (): void {
                Route::get('/', 'all');
                Route::get('/paginate', 'getPaginate');
                Route::get('/search/{search}/paginate', 'getSearch');
                Route::post('/store', 'store');
                Route::get('/marche/{id}', 'getByMarche');
                Route::get('{id}', 'show');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'trash');
                Route::patch('/restore/{id}', 'restore');
            }
        );
        Route::controller(FactureLoyerController::class)->prefix('loyers')->group(
            function (): void {
                Route::get('/', 'all');
                Route::get('/paginate', 'getPaginate');
                Route::get('/search/{search}/paginate', 'getSearch');
                Route::get('/trashed', 'trashed');
                Route::post('/store', 'store');
                Route::get('/marche/{id}', 'getByMarche');
                Route::get('{id}', 'show');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'trash');
                Route::patch('/restore/{id}', 'restore');
            }
        );
        Route::controller(FactureInitialeController::class)->prefix('initiales')->group(
            function (): void {
                Route::get('/', 'all');
                Route::get('/paginate', 'getPaginate');
                Route::get('/search/{search}/paginate', 'getSearch');
                Route::get('/trashed', 'trashed');
                Route::get('/marche/{id}', 'getByMarche');
                Route::get('{id}', 'show');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'trash');
                Route::patch('/restore/{id}', 'restore');
            }
        );
        Route::controller(FactureEquipementController::class)->prefix('equipements')->group(
            function (): void {
                Route::get('/', 'all');
                Route::get('/paginate', 'getPaginate');
                Route::get('/search/{search}/paginate', 'getSearch');
                Route::get('/trashed', 'trashed');
                Route::post('/store', 'store');
                Route::get('/marche/{id}', 'getByMarche');
                Route::get('{id}', 'show');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'trash');
                Route::patch('/restore/{id}', 'restore');
            }
        );
    });
    Route::controller(ChequeController::class)->prefix('cheques')->group(function (): void {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('/marche/{id}', 'getByMarche');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(PaiementLigneController::class)->prefix('paiementsLignes')->group(function (): void {
        Route::get('/', 'all');
        Route::post('/store', 'store');
        Route::get('/marche/{id}', 'getByMarche');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(CommercialController::class)->prefix('commerciaux')->group(function (): void {
        Route::get('/', 'all');
        Route::get('/paginate', 'getPaginate');
        Route::get('/search/{search}/paginate', 'getSearch');
        Route::get('/select', 'getSelect');
        Route::get('/users', 'user');
        Route::post('/attribuer', 'attribuer');
        Route::get('/trashed', 'trashed');
        Route::get('/bordereaux-month/{commercial}', 'getMonthBordereaux');
        Route::get('/marche/{id}', 'getByMarche');
        Route::post('/store', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('/restore/{id}', 'restore');
    });
    Route::controller(BordereauController::class)->prefix('bordereaux')->group(function (): void {
        Route::get('/', 'index');
        Route::get('paginate', 'getPaginate');
        Route::get('for-cashout', 'getForCashout');
        Route::get('search/{search}/paginate', 'getSearch');
        Route::get('select', 'getSelect');
        Route::get('one-for-cashout/{id}', 'getOneForCashout');
        Route::get('uncashed', 'getUncashed');
        Route::get('edit/{id}', 'getEdit');
        Route::get('for-collecte/{id}', 'getOneForCollecte');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'trash');
        Route::patch('restore/{id}', 'restore');
    });
    Route::controller(CollecteController::class)->prefix('collectes')->group(function (): void {
        Route::get('/', 'index');
        Route::get('collected', 'getAlreadyCollected');
        Route::get('globale-collected', 'getAlreadyGlobaleCollected');
        Route::post('store', 'store');
    });
    Route::prefix('caisses')->group(function (): void {
        Route::controller(OuvertureController::class)->prefix('ouvertures')->group(function (): void {
            Route::get('/', 'all');
            Route::get('/paginate', 'getPaginate');
            Route::get('/search/{search}/paginate', 'getSearch');
            Route::post('/store', 'store');
            Route::get('/current/caissier/{id}', 'getCurrentByCaissier');
            Route::get('/using/caissier/{id}', 'getUsingByCaissier');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('/exists/{id}', 'exists');
            Route::get('{id}', 'show');
            Route::put('{id}', 'update');
        });
        Route::controller(FermetureController::class)->prefix('fermetures')->group(function (): void {
            Route::get('/', 'index');
            Route::get('/paginate', 'getPaginate');
            Route::get('/search/{search}/paginate', 'getSearch');
            Route::post('/store', 'store');
            Route::get('{id}', 'show');
            Route::patch('valider', 'valider');
        });
        Route::controller(EncaissementController::class)->prefix('encaissements')->group(function (): void {
            Route::get('/', 'all');
            Route::post('/store', 'store');
            Route::get('/marche/{id}', 'getByMarche');
            Route::get('{id}', 'show');
            Route::get('/print/{id}', 'print');
            Route::put('{id}', 'update');
        });
    });
});
Route::middleware('auth:sanctum')->prefix('dashboard')->group(function (): void {
    Route::prefix('reception')->controller(DashboardReceptionController::class)->group(function (): void {
        Route::get('validation-rate', 'demandeValidationRate');
        Route::get('conversion-rate', 'personneConversionRate');
        Route::get('busy-rate', 'emplacementBusyRate');
        Route::get('equipped-rate', 'emplacementEquippedRate');
        Route::get('linked-rate', 'equipementLinkedRate');
        Route::get('subscribed-rate', 'emplacementSubscribedRate');
    });
});
