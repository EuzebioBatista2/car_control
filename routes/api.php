<?php

use App\Http\Controllers\VehiclesDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Vehicle api */
Route::get('vehicles-data', [VehiclesDataController::class, 'index']);

/* Model api */
Route::get('models/', [VehiclesDataController::class, 'models']);
Route::get('models/{brand}', [VehiclesDataController::class, 'models']);
