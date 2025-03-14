<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\Api\TestController;

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
/**
 * Login route
 */
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    /**
     * Logout route
     */
    Route::post('logout', [AuthController::class, 'logout']);
    // Your protected API routes go here
    Route::post('registerUser', [ManagerController::class, 'registerUser']);
    Route::post('getUserApps', [ManagerController::class, 'getUserApps']);
    Route::post('set-expo-token', [UsersController::class, 'setExpotoken']);

    Route::get('prueba', [TestController::class, 'prueba']);
});