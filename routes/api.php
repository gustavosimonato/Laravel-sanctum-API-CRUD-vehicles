<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\VehicleController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('/register', 'register');
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::delete('logout', [AuthController::class, 'logout']);

    Route::resource('vehicles', VehicleController::class);
});
