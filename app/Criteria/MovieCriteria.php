<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class MovieCriteria.
 *
 * @package namespace App\Criteria;
 */
class MovieCriteria implements CriteriaInterface
{
    protected $filters;

    /**
     * MovieCriteria constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface                   $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->filters['genre_id'])) {
            $genreId = $this->filters['genre_id'];
            $model = $model->whereHas('genres', function ($query) use ($genreId) {
                $query->where('genre_id', $genreId);
            });
        }

        return $model;
    }
}
