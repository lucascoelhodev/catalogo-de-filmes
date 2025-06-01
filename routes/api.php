<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/movies/search', [MovieController::class, 'search']);
Route::post('/favorites', [FavoriteController::class, 'add']);
Route::get('/favorites', [FavoriteController::class, 'index']);
Route::delete('/favorites/{id}', [FavoriteController::class, 'remove']);