<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('movie_genres', function (Blueprint $table) {
            $table->renameColumn('favorite_movie', 'movie_id');
        });
    }

    public function down(): void
    {
        Schema::table('movie_genres', function (Blueprint $table) {
            $table->renameColumn('movie_id', 'favorite_movie');
        });
    }
};
