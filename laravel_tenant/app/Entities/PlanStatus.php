<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PlanStatus.
 *
 * @package namespace App\Entities;
 */
class PlanStatus extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function plans()
    {
        return $this->hasMany('App\Entities\Plan'); 
    }

}
