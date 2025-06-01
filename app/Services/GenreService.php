<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GenreService
{
    protected $apiUrl;
    public $genreService;
    public function __construct()
    {
        $this->apiUrl = env('TMBD_API_URL');
    }
    public function create($genre)
    {
        $genreDb = Genre::where('tmdb_id', $genre['id'])->first();
        if (!$genreDb) {
            $genre = Genre::create([
                'tmdb_id' => $genre['id'],
                'name' => $genre['name'],
            ]);
        } else {
            $genreDb->update([
                'name' => $genre['name'],
            ]);
            $genre = $genreDb;
        }
        return $genre;
    }
}
