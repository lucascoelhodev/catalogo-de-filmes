<?php

namespace App\Services;

use App\Models\FavoriteGenre;
use App\Models\Genre;

class FavoriteGenreService
{
    public function __construct()
    {
    }
    public function create($genre_id, $favorite_id)
    {
        return FavoriteGenre::create([
            'genre_id' => $genre_id,
            'favorite_movie' => $favorite_id
        ]);
    }
}
