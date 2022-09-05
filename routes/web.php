<?php

use App\Http\Controllers\Parametre\AuthController;
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

Route::controller(AuthController::class)->group(function () {
    Route::get('dashboard', 'dashboard');
    Route::post('login', 'login');
    Route::post('deconnecter', 'deconnecter');
    // Route::post('logout', 'logout');
});
