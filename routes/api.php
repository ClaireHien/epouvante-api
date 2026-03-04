<?php 

use App\Http\Controllers\UserController;
use App\Http\Controllers\FanzineController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

// Liste globale des fanzines (pour la vitrine)
Route::get('/fanzines', [FanzineController::class, 'index']);

// Détails d'un numéro spécifique
Route::get('/fanzines/{id}', [FanzineController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/users', [UserController::class, 'index']);      // Liste globale
    Route::get('/user/profile', [UserController::class, 'profile']); // Profil perso
    Route::post('/logout', [UserController::class, 'logout']);   // Déconnexion

    // Processus d'acquisition
    Route::post('/fanzines/{id}/buy', [FanzineController::class, 'buy']);
    Route::post('/fanzines/{id}/pay', [FanzineController::class, 'pay']);

    // Accès au contenu (Téléchargement ou Liseuse)
    Route::get('/fanzines/{id}/download', [FanzineController::class, 'download']);
});