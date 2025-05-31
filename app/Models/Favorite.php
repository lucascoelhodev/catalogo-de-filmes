<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tmdb_id',
        'title',
        'poster_path',
        'release_date',
        'vote_average'
    ];
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'favorite_genres', 'favorite_movie', 'genre_id')
                    ->withTimestamps();
    }
}

