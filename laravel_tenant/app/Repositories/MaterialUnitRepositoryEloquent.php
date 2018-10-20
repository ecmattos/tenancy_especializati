<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MaterialUnitRepository;
use App\Entities\MaterialUnit;
use App\Validators\MaterialUnitValidator;
use App\Presenters\MaterialUnitPresenter;

/**
 * Class MaterialUnitRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MaterialUnitRepositoryEloquent extends BaseRepository implements MaterialUnitRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MaterialUnit::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MaterialUnitValidator::class;
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
        return MaterialUnitPresenter::class;
    }
    
}
