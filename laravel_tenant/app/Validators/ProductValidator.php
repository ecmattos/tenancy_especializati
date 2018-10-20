<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProductValidator.
 *
 * @package namespace App\Validators;
 */
class ProductValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'code' => 'required|unique:products,code',
            'description' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'code' => 'required',
            'description' => 'required'
        ]
    ];

    protected $messages = [
        'required' => 'Obrigatório.',
        'unique' => 'Indisponivel'
    ];

    protected $attributes = [
        'code' => 'Código',
        'description' => 'Descrição'
    ];   
    
}