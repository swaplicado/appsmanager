<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Config\ManagerController;

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

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::middleware(['auth', 'menu'])->group( function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/registry', [HomeController::class, 'index'])->name('user_registry');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Config', 'as' => 'config.', 'prefix' => 'config'], function () {
    Route::get('/userapps', [ManagerController::class, 'userapps'])->name('userapps');
    Route::post('/userapps', [ManagerController::class, 'updateAccess'])->name('upd_user_app');
});