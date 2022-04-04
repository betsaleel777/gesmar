<?php

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
        Route::post('/autoriser', [UtilisateursController::class, 'autoriser']);
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
    Route::controller()->prefix('permissions')->group(function () {
        Route::get('/', [PermissionsController::class, 'all']);
        Route::get('/show/{id}', [PermissionsController::class, 'show']);
    });
});
