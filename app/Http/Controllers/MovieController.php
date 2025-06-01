<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function add(StoreMovieRequest $request)
    {
        $data = $request->getOnlyFields();
        $movie = $this->movieService->addMovie($data);
        return response()->json($movie, 201);
    }
    public function index(Request $request)
    {
        $movies = $this->movieService->listMovies($request);
        return response()->json($movies);
    }
    public function remove($id)
    {
        $this->movieService->removeMovie($id);
        return response()->json(['message' => 'Favorito removido com sucesso!']);
    }
    public function show($id)
    {
        $movie = $this->movieService->getMovie($id);
        return response()->json($movie);
    }
    public function genres()
    {
        $genres = $this->movieService->getGenres();
        return response()->json($genres);
    }
}
