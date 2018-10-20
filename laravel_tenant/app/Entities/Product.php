<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product.
 *
 * @package namespace App\Entities;
 */
class Product extends Model implements Transformable
{
    use TransformableTrait;

    use SoftDeletes;
    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
    	'code',
    	'description'   
    ];

}
