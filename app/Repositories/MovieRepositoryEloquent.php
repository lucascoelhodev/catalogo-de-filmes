<?php

namespace App\Repositories;

use App\Models\Movie;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MovieRepositoryRepository;

/**
 * Class MovieRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MovieRepositoryEloquent extends BaseRepository implements MovieRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Movie::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
