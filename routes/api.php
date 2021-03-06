<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ResolucionController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'factura'
], function ($router) {
    Route::get('get-list', [FacturaController::class, 'index']);
    Route::post('show', [FacturaController::class, 'getByID']);
    Route::post('create', [FacturaController::class, 'store']);
    Route::put('update', [FacturaController::class, 'update']);    
    Route::delete('delete/{factura}', [FacturaController::class, 'destroy']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'resolucion'
], function ($router) {
    Route::get('get-list', [ResolucionController::class, 'index']);
});