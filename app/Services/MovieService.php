<?php

namespace App\Services;

use App\Models\Movie;
use App\Transformers\MovieTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MovieService
{
    protected $apiUrl;

    public $genreService;
    public $favoriteGenreService;
    public function __construct(GenreService $genreService,
    MovieGenreService $favoriteGenreService)
    {
        $this->genreService = $genreService;
        $this->apiUrl = env('TMBD_API_URL');
        $this->favoriteGenreService = $favoriteGenreService;
    }
    public function addMovie($data)
    {
        DB::beginTransaction();
        $favorite = Movie::create($data);
        $genres = $this->searchGenresByMovieId($data['tmdb_id']);
        foreach($genres as $genre) {
            $genreDb = $this->genreService->create($genre);
            $this->favoriteGenreService->create($genreDb->id, $favorite->id);
        }
        $response = fractal($favorite, new MovieTransformer())->respond();
        $dataArray = json_decode($response->getContent(), true);
        DB::commit();
        return $dataArray;
    }
    public function searchGenresByMovieId($movie_id)
    {
        $response = Http::get("{$this->apiUrl}/movie/{$movie_id}", [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR'
        ]);
        return $response->json()['genres'];
    }
    public function listMovies()
{
    $movies = Movie::with('genres')->get();

    $response = fractal()
        ->collection($movies)
        ->transformWith(new MovieTransformer())
        ->include('genres')
        ->respond();

    $dataArray = json_decode($response->getContent(), true);
    return response()->json($dataArray);
}

public function removeMovie($id)
{        
    DB::beginTransaction();
    $favorite = Movie::findOrFail($id);
    $favoriteGenres = $favorite->favoriteGenres;
    if(isset($favoriteGenres)){
        $favoriteGenres->each(function ($favoriteGenre) {
            $this->favoriteGenreService->delete($favoriteGenre->id);
        });
    }
    $favorite->delete();
    DB::commit();
    return true;
}
}
