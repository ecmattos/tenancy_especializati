<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Plan.
 *
 * @package namespace App\Entities;
 */
class Plan extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'details',
        'plan_type_id',
        'plan_sub_type_id',
        'plan_status_id',
        'price'
    ];

    public function plan_type()
    {
        return $this->belongsTo('App\Entities\PlanType'); 
    }

    public function plan_sub_type()
    {
        return $this->belongsTo('App\Entities\PlanSubType'); 
    }

    public function plan_status()
    {
        return $this->belongsTo('App\Entities\PlanStatus'); 
    }

}
