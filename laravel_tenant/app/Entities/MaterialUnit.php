<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MaterialUnit.
 *
 * @package namespace App\Entities;
 */
class MaterialUnit extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = 'tenant';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'code',
    	'description'
    ];

    public function materials()
    {
        return $this->hasMany('App\Entities\Material');   
    }

}
