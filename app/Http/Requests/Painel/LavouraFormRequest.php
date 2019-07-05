<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class LavouraFormRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descricao'     => 'min:3|max:100',
            'hectares'      => 'required'
        ];
    }

    public function messages(){
        return [
            'descricao.required'    => 'O campo nome é obrigatório!',
            'descricao.min'         => 'O nome não pode  ter menos de 3 cararteres!',
            'descricao.max'         => 'O nome não pode  ter mais de 100 cararteres!',

            'hectares.required'     => 'O campo hectares é obrigatório!',
            'hectares.numeric'      => 'Os hectares só pode conter numeros!',
            
        ];
    }
}
