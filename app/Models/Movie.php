<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;
    protected $table = 'movies';
    protected $fillable = [
        'tmdb_id',
        'title',
        'poster_path',
        'release_date',
        'vote_average'
    ];
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id')
            ->withTimestamps();
    }
    public function favoriteGenres()
    {
        return $this->hasMany(MovieGenre::class, 'movie_id', 'id');
    }
}
