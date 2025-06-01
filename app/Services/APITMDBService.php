<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class APITMDBService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('TMBD_API_URL');
    }

    public function searchMovies($query)
    {
        $response = Http::get("{$this->apiUrl}/search/movie", [
            'api_key' => env('TMDB_API_KEY'),
            'query' => $query,
            'language' => 'pt-BR'
        ]);
        return $response->json();
    }
    public function getMovie($movie_id)
    {
        $response = Http::get("{$this->apiUrl}/movie/{$movie_id}", [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR'
        ]);
        return $response->json();
    }
}
