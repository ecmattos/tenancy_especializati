<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TrashRepository;
use App\Entities\Trash;
use App\Validators\TrashValidator;

/**
 * Class TrashRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TrashRepositoryEloquent extends BaseRepository implements TrashRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Trash::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TrashValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
