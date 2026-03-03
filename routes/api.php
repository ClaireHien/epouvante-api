<?php 

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

// Routes protégées (nécessitent d'être connecté)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);      // Liste globale
    Route::get('/user/profile', [UserController::class, 'profile']); // Profil perso
    Route::post('/logout', [UserController::class, 'logout']);   // Déconnexion
});