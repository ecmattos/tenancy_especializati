<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PlanRepository;
use App\Entities\Plan;
use App\Validators\PlanValidator;
use App\Presenters\PlanPresenter;

/**
 * Class PlanRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PlanRepositoryEloquent extends BaseRepository implements PlanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plan::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PlanValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return PlanPresenter::class;
    }
    
}
