<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'params' => 'required',
            'xdescription' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'params' => 'Parâmetros',
            'xdescription' => 'Descrição'
        ];
    }
    
    public function messages()
    {
        return [
            'required' => ':attribute >> Preenchimentowww obrigatório.',
        ];
    }
  
}
