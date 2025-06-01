<?php

namespace App\Services;

use App\Models\FavoriteGenre;
use App\Models\Genre;

class FavoriteGenreService
{
    public function __construct() {}
    public function create($genre_id, $favorite_id)
    {
        return FavoriteGenre::create([
            'genre_id' => $genre_id,
            'favorite_movie' => $favorite_id
        ]);
    }
    public function delete($favoriteGenreId)
    {
        $favoriteGenre = FavoriteGenre::find($favoriteGenreId);
        if ($favoriteGenre) {
            $favoriteGenre->delete();
            return true;
        }
        return false;
    }
}
