<?php

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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::get("/articles/favourite/author", [\App\Http\Controllers\Api\ArticleController::class, 'getArticlesByAuthors']);
    Route::get("/articles/favourite/category", [\App\Http\Controllers\Api\ArticleController::class, 'getArticlesByCategories']);

    Route::post("/articles/favourite/author", [\App\Http\Controllers\Api\UserAuthorController::class, 'store']);
    Route::post("/articles/favourite/category", [\App\Http\Controllers\Api\UserCategoryController::class, 'store']);

});

Route::post("/signup", [\App\Http\Controllers\Api\AuthController::class, 'signup']);
Route::post("/login", [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::get("/articles", [\App\Http\Controllers\Api\ArticleController::class, 'index']);

