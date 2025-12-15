<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use App\Models\Recipe;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
// Recipes
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{recipeId}', [RecipeController::class, 'show']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [UserController::class, 'fetchCurrentUser']);
    Route::post('/recipes', [RecipeController::class, 'store']);

    Route::get('/my-recipes', [RecipeController::class, 'fetchMyRecipes']);

    Route::post('/recipes/{recipeId}/comments', [CommentController::class, 'store']);

    Route::post('/recipes/{recipeId}/reactions', [ReactionController::class, 'store']);


    Route::post('/logout', [LogoutController::class, 'logout']);
});