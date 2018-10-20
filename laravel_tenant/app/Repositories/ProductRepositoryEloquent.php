<?php

namespace App\Repositories;

use \Prettus\Repository\Eloquent\BaseRepository;
use \Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductRepository;
use App\Entities\Product;
use App\Validators\ProductValidator;
use App\Validators\ProductSearchValidator;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return ProductValidator::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function searchValidator()
    {
        return ProductSearchValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function productsSearchDescription($srch_product_terms)
	{
		if(!is_array($srch_product_terms)) 
        {
            #return "É array";     
            $srch_product_terms = explode(" ",$srch_product_terms);
        }
        else
        {
            $srch_product_terms = $srch_product_terms;
        } 
        #dd($srch_product_terms);
        
        return $this->model
			->where(function($query) use ($srch_product_terms) 
			{
				if($srch_product_terms)
				{
					$srch_product_terms_total = count($srch_product_terms);

                    for($i=0 ; $i < $srch_product_terms_total ; $i++ )
                    {
    					$query->where('description','LIKE','%'.$srch_product_terms[$i].'%');
					}
				}
			})
			->orderBy('description', 'asc')
			->get();
    }
    
    public function productsSearchCode($srch_product_terms)
	{
		return $this->model
            ->where('code','=', $srch_product_terms)
            ->get();
    }
    
}
