<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Services\MovieService;

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
    public function index()
    {
        $movies = $this->movieService->listMovies();
        return response()->json($movies);
    }
    public function remove($id)
    {
        $this->movieService->removeMovie($id);
        return response()->json(['message' => 'Favorito removido com sucesso!']);
    }
}
