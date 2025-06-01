<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tmdb_id' => [
                'required',
                'integer',
                Rule::unique('movies')->whereNull('deleted_at'),
            ],
            'title' => 'required|string|max:255',
            'poster_path' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'vote_average' => 'nullable|numeric',
        ];
    }
    public function getOnlyFields(): array
    {
        return $this->only([
            'tmdb_id',
            'title',
            'poster_path',
            'release_date',
            'vote_average',
        ]);
    }
}
