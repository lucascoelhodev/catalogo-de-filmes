<?php

namespace App\Services;

use App\Models\MovieGenre;

class MovieGenreService
{
    public function __construct() {}
    public function create($genre_id, $favorite_id)
    {
        return MovieGenre::create([
            'genre_id' => $genre_id,
            'movie_id' => $favorite_id
        ]);
    }
    public function delete($favoriteGenreId)
    {
        $favoriteGenre = MovieGenre::find($favoriteGenreId);
        if ($favoriteGenre) {
            $favoriteGenre->delete();
            return true;
        }
        return false;
    }
}
