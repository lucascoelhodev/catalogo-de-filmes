<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Genre;

class GenreTransformer extends TransformerAbstract
{
    public function transform(Genre $genre): array
    {
        return [
            'id' => $genre->id,
            'tmdb_id' => $genre->tmdb_id,
            'name' => $genre->name
        ];
    }
}
