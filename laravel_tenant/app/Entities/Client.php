<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Client.
 *
 * @package namespace App\Entities;
 */
class Client extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'cpfcnpj',
        'name',
        'email',
        'domain',
        'database',
        'hostname',
        'username',
        'password'
    ];

    public function users()
    {
        return $this->hasMany('App\Entities\User');   
    }
}
