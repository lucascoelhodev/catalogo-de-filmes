<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteRequest;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function add(StoreFavoriteRequest $request)
    {
        $data = $request->getOnlyFields();
        $favorite = $this->favoriteService->addFavorite($data);
        return response()->json($favorite, 201);
    }

    
}
