<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserVerifyValidator.
 *
 * @package namespace App\Validators;
 */
class UserVerifyValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'codeVerification' => 'required'
        ]
    ];

    protected $messages = [
        'required' => 'Obrigatório.'
    ];

    protected $attributes = [
        'codeVerification' => 'Código de verificação'
    ];   
    
}