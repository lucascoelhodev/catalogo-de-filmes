<?php

use App\Http\Controllers\APITMDBController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::get('/movies/search', [APITMDBController::class, 'search']);
Route::get('/movies/{id}', [APITMDBController::class, 'getMovie']);
Route::post('/favorites', [FavoriteController::class, 'add']);
Route::get('/favorites', [FavoriteController::class, 'index']);
Route::delete('/favorites/{id}', [FavoriteController::class, 'remove']);