<?php

use App\Http\Controllers\Api\RestaurantController;
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

// Restaurant API routes
Route::prefix('restaurants')->group(function () {

    Route::get('/storage/{path}', [RestaurantController::class, 'proxyImage'])->where('path', '.*');
    Route::get('/recommendations', [RestaurantController::class, 'getRecommendations']);
    Route::get('/search', [RestaurantController::class, 'search']);
    Route::apiResource('/', RestaurantController::class)->except(['index', 'create', 'edit']);
});
