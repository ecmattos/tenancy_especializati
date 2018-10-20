<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProductValidator.
 *
 * @package namespace App\Validators;
 */
class ProductSearchValidator extends LaravelValidator
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
        'required' => 'Obrigatórioo.',
    ];

    protected $attributes = [
        'description_terms' => 'Termos'
    ];    
}
