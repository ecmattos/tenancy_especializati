<?php

namespace App\Repositories;

use \Prettus\Repository\Eloquent\BaseRepository;
use \Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MaterialRepository;
use App\Entities\Material;
use App\Validators\MaterialValidator;
use App\Validators\MaterialSearchValidator;
use App\Presenters\MaterialPresenter;

use Prettus\Repository\Presenter\ModelFractalPresenter;

/**
 * Class MaterialRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MaterialRepositoryEloquent extends BaseRepository implements MaterialRepository
{
    protected $fieldSearchable = [
        'code' => 'like',
        'description' => 'like'
    ];
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Material::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return MaterialValidator::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function searchValidator()
    {
        return MaterialSearchValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function materialsSearchDescription($srch_material_terms)
	{
		if(!is_array($srch_material_terms)) 
        {
            #return "É array";     
            $srch_material_terms = explode(" ",$srch_material_terms);
        }
        else
        {
            $srch_material_terms = $srch_material_terms;
        } 
        #dd($srch_material_terms);
        
        return $this->model
            ->select(
                'materials.*',
                'material_units.code AS material_unit_code',
                'material_units.description AS material_unit_description')
            ->join('material_units','materials.material_unit_id','=','material_units.id')
            ->where(function($query) use ($srch_material_terms) 
			{
				if($srch_material_terms)
				{
					$srch_material_terms_total = count($srch_material_terms);

                    for($i=0 ; $i < $srch_material_terms_total ; $i++ )
                    {
    					$query->where('materials.description','LIKE','%'.$srch_material_terms[$i].'%');
					}
				}
			})
			->orderBy('materials.description', 'asc')
            ->get();
    }
    
    public function materialsSearchCode($srch_material_terms)
	{
		return $this->model
            ->where('code','=', $srch_material_terms)
            ->get();
    }

    public function presenter()
    {
        return MaterialPresenter::class;
    }
    
}
