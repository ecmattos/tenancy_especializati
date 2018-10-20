<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PlanTypeRepository;
use App\Entities\PlanType;
use App\Validators\PlanTypeValidator;
use App\Presenters\PlanTypePresenter;

/**
 * Class PlanTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PlanTypeRepositoryEloquent extends BaseRepository implements PlanTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PlanTypeValidator::class;
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
        return PlanTypePresenter::class;
    }
    
}
