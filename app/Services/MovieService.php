<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class MovieService
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
}
