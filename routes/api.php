<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/movies/search', [MovieController::class, 'search']);
Route::post('/favorites', [FavoriteController::class, 'add']);
