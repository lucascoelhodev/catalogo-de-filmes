<?php

namespace App\Services;

use App\Criteria\MovieCriteria;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Transformers\GenreTransformer;
use App\Transformers\MovieTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MovieService
{
    protected $apiUrl;

    public $genreService;
    public $favoriteGenreService;
    public $movieRepository;
    public function __construct(
        GenreService $genreService,
        MovieGenreService $favoriteGenreService,
        MovieRepository $movieRepository
    ) {
        $this->genreService = $genreService;
        $this->apiUrl = env('TMBD_API_URL');
        $this->favoriteGenreService = $favoriteGenreService;
        $this->movieRepository = $movieRepository;
    }
    public function addMovie($data)
    {
        DB::beginTransaction();
        $favorite = Movie::create($data);
        $genres = $this->searchGenresByMovieId($data['tmdb_id']);
        foreach ($genres as $genre) {
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
    public function listMovies($request)
    {
        $filters = $request->only(['genre_id']);
        $this->movieRepository->pushCriteria(new MovieCriteria($filters));
        $movies = $this->movieRepository->with('genres')->all();
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
        if (isset($favoriteGenres)) {
            $favoriteGenres->each(function ($favoriteGenre) {
                $this->favoriteGenreService->delete($favoriteGenre->id);
            });
        }
        $favorite->delete();
        DB::commit();
        return true;
    }
    public function getMovie($id)
    {
        $movie = $this->movieRepository->find($id);
        if (!$movie) {
            return response()->json(['message' => 'Filme não encontrado'], 404);
        }
        $response = fractal($movie, new MovieTransformer())->respond();
        $dataArray = json_decode($response->getContent(), true);
        return response()->json($dataArray);
    }
    public function getGenres()
    {
        $genres = $this->genreService->all();
        $dataArray = json_decode($genres->getContent(), true);
        return response()->json($dataArray);
    }
}
