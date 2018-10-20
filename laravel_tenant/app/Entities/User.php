<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $connection = 'mysql';    
    
    const ROLE_SUPER = 'Super';
    const ROLE_ADMIN = 'Admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'name', 
        'email', 
        'password', 
        'role',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    public function client()
    {
        return $this->belongsTo('App\Entities\Client'); 
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        ##return [
        ##    'user' => [
        ##        'id' => $this->id,
        ##        'name' => $this->name,
        ##        'email' => $this->email
        ##    ]
        ##];

        return [];
    }
}