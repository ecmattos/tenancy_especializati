<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PlanSubTypeRepository;
use App\Entities\PlanSubType;
use App\Validators\PlanSubTypeValidator;
use App\Presenters\PlanSubTypePresenter;

/**
 * Class PlanSubTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PlanSubTypeRepositoryEloquent extends BaseRepository implements PlanSubTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanSubType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PlanSubTypeValidator::class;
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
        return PlanSubTypePresenter::class;
    }
    
}
