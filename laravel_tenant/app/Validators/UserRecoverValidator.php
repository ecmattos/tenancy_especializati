<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserRecoverValidator.
 *
 * @package namespace App\Validators;
 */
class UserRecoverValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'email' => 'required|email'
        ]
    ];

    protected $messages = [
        'required' => 'Obrigatório.',
        'email' => 'Inválido'
    ];

    protected $attributes = [
        'email' => 'E-mail'
    ];   
    
}