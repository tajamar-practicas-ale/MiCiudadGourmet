<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\CategoryController;

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Rutas públicas (no requieren autenticación)
Route::get('restaurants', [RestaurantController::class, 'index']);
Route::get('restaurants/{id}', [RestaurantController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

// Rutas protegidas (requieren token de acceso)
Route::middleware('auth:sanctum')->group(function () {
    // CRUD de restaurantes
    Route::post('restaurants', [RestaurantController::class, 'store']);
    Route::put('restaurants/{id}', [RestaurantController::class, 'update']);
    Route::delete('restaurants/{id}', [RestaurantController::class, 'destroy']);
    
    // Reseñas
    Route::post('restaurants/{restaurant}/reviews', [ReviewController::class, 'store']);
    Route::put('reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);

    // Categorías
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Favoritos
    Route::post('restaurants/{restaurant}/favorite', [FavoriteController::class, 'store']);
    Route::delete('restaurants/{restaurant}/favorite', [FavoriteController::class, 'destroy']);

    // Fotos
    Route::post('restaurants/{restaurant}/photos', [PhotoController::class, 'store']);
    Route::delete('photos/{id}', [PhotoController::class, 'destroy']);
});
