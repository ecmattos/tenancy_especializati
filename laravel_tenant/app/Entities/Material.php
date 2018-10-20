<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Material.
 *
 * @package namespace App\Entities;
 */
class Material extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = 'tenant';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'code',
    	'description',
    	'material_unit_id'
    ];

    public function material_unit()
    {
        return $this->belongsTo('App\Entities\MaterialUnit'); 
    }

}
