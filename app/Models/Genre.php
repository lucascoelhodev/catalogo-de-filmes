<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tmdb_id',
        'name',
    ];
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_genres', 'genre_id', 'movie_id')
                    ->withTimestamps();
    }
}
