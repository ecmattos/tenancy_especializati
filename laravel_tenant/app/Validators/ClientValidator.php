<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ClientValidator.
 *
 * @package namespace App\Validators;
 */
class ClientValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'cpfcnpj'   => 'cnpj_cpf|required|unique:clients,cpfcnpj',
            'name'      => 'max:100|required|unique:clients,name',
            'email'     => 'max:100|required|email|unique:clients,email'
        ]
    ];

    protected $messages = [
        'cnpj_cpf'  => 'Inválido',
        'required'  => 'Obrigatório.',
        'unique'    => 'Indisponivel',
        'email'     => 'Inválido'
    ];

    protected $attributes = [
        'cpfcnpj'   => 'CPF/CNPJ',
        'name'      => 'Descrição',
        'email'     => 'E-mail'
    ]; 
}
