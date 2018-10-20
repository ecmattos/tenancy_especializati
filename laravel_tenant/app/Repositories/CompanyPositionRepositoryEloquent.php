<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanyPositionRepository;
use App\Entities\CompanyPosition;
use App\Validators\CompanyPositionValidator;
use App\Presenters\CompanyPositionPresenter;


/**
 * Class CompanyPositionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompanyPositionRepositoryEloquent extends BaseRepository implements CompanyPositionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanyPosition::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CompanyPositionValidator::class;
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
        return CompanyPositionPresenter::class;
    }
    
}
