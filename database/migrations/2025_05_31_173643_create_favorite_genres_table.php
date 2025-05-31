<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorite_genres', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('favorite_movie')->unsigned();
            $table->bigInteger('genre_id')->unsigned();
            $table->foreign('favorite_movie')->references('id')->on('favorites')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_genres');
    }
};
