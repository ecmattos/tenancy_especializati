<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class MaterialValidator.
 *
 * @package namespace App\Validators;
 */
class MaterialSearchValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'description_terms' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'description_terms' => 'required'
        ]
    ];

    protected $messages = [
        'required' => 'Obrigatório.',
    ];

    protected $attributes = [
        'description_terms' => 'Termos'
    ];    
}
