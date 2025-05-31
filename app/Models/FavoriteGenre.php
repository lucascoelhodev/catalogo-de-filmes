<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteGenre extends Model
{
    use SoftDeletes;
    protected $table = 'favorite_genres';
    protected $fillable = [
        'favorite_movie',
        'genre_id',
    ];
}
