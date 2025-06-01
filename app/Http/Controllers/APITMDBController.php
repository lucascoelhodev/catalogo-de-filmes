<?php

namespace App\Http\Controllers;

use App\Services\APITMDBService;
use Illuminate\Http\Request;

class APITMDBController extends Controller
{
    protected $apiTMDBService;

    public function __construct(APITMDBService $apiTMDBService)
    {
        $this->apiTMDBService = $apiTMDBService;
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        if (!$query) {
            return response()->json(['error' => 'Parâmetro de busca é obrigatório'], 422);
        }
        $results = $this->apiTMDBService->searchMovies($query);

        return response()->json($results);
    }
    public function getMovie($id){
        return $this->apiTMDBService->getMovie($id);
    }
}
