<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Config\ManagerController;
use App\Http\Controllers\Permissions\RolesVsPermissionsController;
use App\Http\Controllers\Permissions\UsersVsPermissionsController;

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

    /**
     * Roles vs permisos
     */
    Route::get('/rolesvspermissions', [RolesVsPermissionsController::class, 'index'])->name('rolesvspermissions_index');
    Route::post('/rolesvspermissions/getPermissions', [RolesVsPermissionsController::class, 'getRolPermissions'])->name('rolesvspermissions_getRolPermissions');
    Route::post('/rolesvspermissions/create', [RolesVsPermissionsController::class, 'create'])->name('rolesvspermissions_create');
    Route::post('/rolesvspermissions/update', [RolesVsPermissionsController::class, 'update'])->name('rolesvspermissions_update');
    Route::post('/rolesvspermissions/delete', [RolesVsPermissionsController::class, 'delete'])->name('rolesvspermissions_delete');

    /**
     * Usuarios vs permisos
     */
    Route::get('/usersvspermissions', [UsersVsPermissionsController::class, 'index'])->name('usersVsPermissions_index');
    Route::post('/usersvspermissions/getPermissions', [UsersVsPermissionsController::class, 'getUserPermission'])->name('usersvspermissions_getUserPermissions');
    Route::post('/usersvspermissions/create', [UsersVsPermissionsController::class, 'create'])->name('usersvspermissions_create');
    Route::post('/usersvspermissions/update', [UsersVsPermissionsController::class, 'update'])->name('usersvspermissions_update');
    Route::post('/usersvspermissions/delete', [UsersVsPermissionsController::class, 'delete'])->name('usersvspermissions_delete');
});

Route::group(['middleware' => ['auth', 'menu'], 'namespace' => 'Config', 'as' => 'config.', 'prefix' => 'config'], function () {
    Route::get('/userapps', [ManagerController::class, 'userapps'])->name('userapps');
    Route::post('/userapps', [ManagerController::class, 'updateAccess'])->name('upd_user_app');
    Route::post('/getUser', [ManagerController::class, 'getUser'])->name('getUser');
    Route::post('/create', [ManagerController::class, 'createUser'])->name('createUser');
    Route::post('/getRolesApp', [ManagerController::class, 'getRolesApp'])->name('getRolesApp');
    Route::post('/update', [ManagerController::class, 'updateUser'])->name('updateUser');
    Route::post('/delete', [ManagerController::class, 'deleteUser'])->name('deleteUser');
});