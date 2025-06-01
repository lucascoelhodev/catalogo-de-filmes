<?php

use App\Http\Controllers\APITMDBController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/tmdb/search', [APITMDBController::class, 'search']);
Route::get('/tmdb/{id}', [APITMDBController::class, 'getMovie']);
Route::post('/movie', [MovieController::class, 'add']);
Route::get('/movie', [MovieController::class, 'index']);
Route::delete('/movie/{id}', [MovieController::class, 'remove']);