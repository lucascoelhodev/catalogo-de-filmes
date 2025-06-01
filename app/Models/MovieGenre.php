<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieGenre extends Model
{
    use SoftDeletes;
    protected $table = 'movie_genres';
    protected $fillable = [
        'movie_id',
        'genre_id',
    ];
}
