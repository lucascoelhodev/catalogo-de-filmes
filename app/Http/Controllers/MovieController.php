<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        if (!$query) {
            return response()->json(['error' => 'Query param is required'], 422);
        }
        $results = $this->movieService->searchMovies($query);

        return response()->json($results);
    }
}
