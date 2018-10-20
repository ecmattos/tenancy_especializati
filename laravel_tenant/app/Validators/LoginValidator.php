<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class LoginValidator.
 *
 * @package namespace App\Validators;
 */
class LoginValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'email' => 'required|email',
            'password' => 'required_'
        ]
    ];

    protected $messages = [
        'required' => 'Obrigatório.',
        'email' => 'Inválido'
    ];

    protected $attributes = [
        'email' => 'E-mail',
        'password' => 'Senha'
    ];   
    
}