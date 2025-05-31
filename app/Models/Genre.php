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
    public function favorites()
    {
        return $this->belongsToMany(Favorite::class, 'favorite_genres', 'genre_id', 'favorite_movie')
                    ->withTimestamps();
    }
}
