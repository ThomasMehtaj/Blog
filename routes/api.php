<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\GuestMiddleware;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Routes publiques accessibles sans authentification

// Route qui liste tout les articles
Route::get('/articles', [ArticleController::class, 'list']);
// Route qui permet de lire un article spécifié par son id
Route::get('/article/{id}', [ArticleController::class, 'read'])->where('id', '[0-9]+');


// Routes protégées par JWT Auth
Route::middleware('jwt.auth')->group(function () {

// Route qui créé un nouvel article
Route::post('/article', [ArticleController::class, 'create']);

//Route qui permet de mettre à jour un article spécifié par son id
Route::put('/article/{id}', [ArticleController::class, 'update'])->where('id', '[0-9]+');
Route::patch('/article/{id}', [ArticleController::class, 'update'])->where('id', '[0-9]+');

//Route qui permet de supprimer un article spécifié par son id
Route::delete('/article/{id}', [ArticleController::class, 'delete'])->where('id', '[0-9]+');

// Route qui permet de se déconnecter
Route::post('/logout', [UserController::class, 'logout']);

// Route pour récupérer l'utilisateur connecté
Route::get('/me', [UserController::class, 'me'])->name('me');

//Route qui permet de liker un article
Route::post('/article/like', [LikeController::class, 'create']);

//Route qui permet de supprimer un like d'un article
Route::delete('/article/like', [LikeController::class, 'delete']);
});

// Routes pour l'authentification accessibles aux invités
Route::middleware('guest')->group(function () {

// Route qui permet de se connecter
Route::post('login', [UserController::class, 'login'])->name('login');
   });
   

