<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;

class FavoriteMovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_movies_api_tmdb_mocked()
    {
        Http::fake([
            'https://api.themoviedb.org/3/search/movie*' => Http::response([
                'results' => [
                    ['id' => 1, 'title' => 'Harry', 'genre_ids' => [28]],
                    ['id' => 2, 'title' => 'Matrix Reloaded', 'genre_ids' => [28]],
                ],
            ], 200)
        ]);

        $response = $this->getJson('/api/tmdb/search?query=harry');

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'results')
                 ->assertJsonFragment(['title' => 'Harry']);
    }


    public function test_create_favorite_validation_error()
    {
        // Sem título, por exemplo
        $payload = [
            'tmdb_id' => 12345,
            'genre' => 'Action',
        ];

        $response = $this->postJson('/api/movie', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('title');
    }
}
