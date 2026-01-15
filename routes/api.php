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
    
    // Public Read Endpoints
    Route::get('/', [RestaurantController::class, 'index']); // List / Recommendations
    Route::get('/search', [RestaurantController::class, 'search']);
    Route::get('/storage/{path}', [RestaurantController::class, 'proxyImage'])->where('path', '.*');
    Route::get('/{idOrSlug}', [RestaurantController::class, 'show']); // ID or Slug

    // Admin / Write Endpoints
    // TODO: These are currently disabled for security. 
    // If Mobile Admin is needed, uncomment and secure with 'auth:sanctum'.
    // Route::post('/', [RestaurantController::class, 'store']);
    // Route::put('/{id}', [RestaurantController::class, 'update']);
    // Route::delete('/{id}', [RestaurantController::class, 'destroy']);
});
