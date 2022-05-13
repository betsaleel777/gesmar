<?php

use App\Http\Controllers\Parametre\Architecture\NiveausController;
use App\Http\Controllers\Parametre\Architecture\PavillonsController;
use App\Http\Controllers\Parametre\Architecture\SitesController;
use App\Http\Controllers\Parametre\Architecture\TypeEmplacementsController;
use App\Http\Controllers\Parametre\Architecture\ZonesController;
use App\Http\Controllers\Parametre\AuthController;
use App\Http\Controllers\Parametre\PermissionsController;
use App\Http\Controllers\Parametre\RolesController;
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
        Route::get('{id}', [SitesController::class, 'show']);
        Route::delete('{id}', [SitesController::class, 'trash']);
        Route::get('/restore/{id}', [SitesController::class, 'restore']);
    });
    Route::prefix('pavillons')->group(function () {
        Route::get('/', [PavillonsController::class, 'all']);
        Route::get('/trashed', [PavillonsController::class, 'trashed']);
        Route::post('/store', [PavillonsController::class, 'store']);
        Route::get('{id}', [PavillonsController::class, 'show']);
        Route::delete('{id}', [PavillonsController::class, 'trash']);
        Route::get('/restore/{id}', [PavillonsController::class, 'restore']);
    });
    Route::prefix('niveaus')->group(function () {
        Route::get('/', [NiveausController::class, 'all']);
        Route::get('/trashed', [NiveausController::class, 'trashed']);
        Route::post('/store', [NiveausController::class, 'store']);
        Route::get('{id}', [NiveausController::class, 'show']);
        Route::delete('{id}', [NiveausController::class, 'trash']);
        Route::get('/restore/{id}', [NiveausController::class, 'restore']);
    });
    Route::prefix('zones')->group(function () {
        Route::get('/', [ZonesController::class, 'all']);
        Route::get('/trashed', [ZonesController::class, 'trashed']);
        Route::post('/store', [ZonesController::class, 'store']);
        Route::get('{id}', [ZonesController::class, 'show']);
        Route::delete('{id}', [ZonesController::class, 'trash']);
        Route::get('/restore/{id}', [ZonesController::class, 'restore']);
    });
    Route::prefix('type_emplacements')->group(function () {
        Route::get('/', [TypeEmplacementsController::class, 'all']);
        Route::get('/trashed', [TypeEmplacementsController::class, 'trashed']);
        Route::post('/store', [TypeEmplacementsController::class, 'store']);
        Route::get('{id}', [TypeEmplacementsController::class, 'show']);
        Route::delete('{id}', [TypeEmplacementsController::class, 'trash']);
        Route::get('/restore/{id}', [TypeEmplacementsController::class, 'restore']);
    });
});
