<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Favorite;
use Carbon\Carbon;

class FavoriteTransformer extends TransformerAbstract  
{
    protected array $availableIncludes = [
        'genres'
    ];

    public function transform(Favorite $favorite): array
    {
        return [
            'id' => $favorite->id,
            'tmdb_id' => $favorite->tmdb_id,
            'title' => $favorite->title,
            'poster_path' => $favorite->poster_path,
            'release_date' => $favorite->release_date,
            'release_date_label' => Carbon::parse($favorite->release_date)->format('d/m/Y'),
            'vote_average' => $favorite->vote_average,
            'created_at' => $favorite->created_at,
            'updated_at' => $favorite->updated_at,
        ];
    }

    public function includeGenres(Favorite $favorite)
    {
        return $this->collection($favorite->genres, new GenreTransformer());
    }
}
