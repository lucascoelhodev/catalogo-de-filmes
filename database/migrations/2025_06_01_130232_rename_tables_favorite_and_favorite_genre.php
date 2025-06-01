<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('favorites', 'movies');

        Schema::rename('favorite_genres', 'movie_genres');
    }

    public function down(): void
    {
        // Volta para o nome antigo, caso precise de rollback
        Schema::rename('movies', 'favorites');
        Schema::rename('movie_genres', 'favorite_genres');
    }
};
