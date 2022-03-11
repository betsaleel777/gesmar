<?php

use App\Http\Controllers\Decisionel\DashbaordController;
use App\Http\Controllers\Parametre\AuthController;
use App\Http\Controllers\Parametre\PermissionsController;
use App\Http\Controllers\Parametre\RolesController;
use App\Http\Controllers\Parametre\UtilisateursController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/', [DashbaordController::class, 'index']);

Route::controller(AuthController::class)->group(function () {
    Route::get('dashboard', 'dashboard');
    Route::get('login', 'index')->name('login');
    Route::post('login', 'login')->name('connexion');
    Route::get('logout', 'logout')->name('deconnexion');
});

Route::prefix('parametres')->group(function () {
    Route::prefix('administration')->name('admin.')->group(function () {
        Route::controller(UtilisateursController::class)->prefix('utilisateurs')->name('user.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'add')->name('add');
            Route::post('/insert', 'insert')->name('insert');
            Route::post('/informations', 'informations')->name('informations');
            Route::post('/notifications', 'notifications')->name('notifications');
            Route::post('/permissions', 'permissions')->name('permissions');
            Route::post('/securite', 'securite')->name('securite');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/setting/{id}/{panel}', 'setting')->name('setting');
            Route::get('/trash/{id}', 'trash')->name('trash');
            Route::get('/archive', 'archive')->name('archive');
            Route::get('/restore/{id}', 'restore')->name('restore');
        });
        Route::controller(RolesController::class)->prefix('roles')->name('role.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'add')->name('add');
            Route::post('/insert', 'insert')->name('insert');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/trash/{id}', 'trash')->name('trash');
            Route::get('/archive', 'archive')->name('archive');
            Route::get('/restore/{id}', 'restore')->name('restore');
        });
        Route::controller(PermissionsController::class)->prefix('permissions')->name('permission.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
        });
    });
});
