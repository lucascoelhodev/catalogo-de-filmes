<?php

namespace App\Services;

use App\Models\Favorite;
use App\Transformers\FavoriteTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FavoriteService
{
    protected $apiUrl;

    public $genreService;
    public $favoriteGenreService;
    public function __construct(GenreService $genreService,
    FavoriteGenreService $favoriteGenreService)
    {
        $this->genreService = $genreService;
        $this->apiUrl = env('TMBD_API_URL');
        $this->favoriteGenreService = $favoriteGenreService;
    }
    public function addFavorite($data)
    {
        DB::beginTransaction();
        $favorite = Favorite::create($data);
        $genres = $this->searchGenresByMovieId($data['tmdb_id']);
        foreach($genres as $genre) {
            $genreDb = $this->genreService->create($genre);
            $this->favoriteGenreService->create($genreDb->id, $favorite->id);
        }
        $response = fractal($favorite, new FavoriteTransformer())->respond();
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
    public function listFavorites()
{
    $favorites = Favorite::with('genres')->get();

    $response = fractal()
        ->collection($favorites)
        ->transformWith(new FavoriteTransformer())
        ->include('genres')
        ->respond();

    $dataArray = json_decode($response->getContent(), true);
    return response()->json($dataArray);
}

public function removeFavorite($id)
{        
    DB::beginTransaction();
    $favorite = Favorite::findOrFail($id);
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
