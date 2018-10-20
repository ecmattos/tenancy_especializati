<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PlanStatusRepository;
use App\Entities\PlanStatus;
use App\Validators\PlanStatusValidator;
use App\Presenters\PlanStatusPresenter;

/**
 * Class PlanStatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PlanStatusRepositoryEloquent extends BaseRepository implements PlanStatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanStatus::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PlanStatusValidator::class;
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
        return PlanStatusPresenter::class;
    }
    
}
