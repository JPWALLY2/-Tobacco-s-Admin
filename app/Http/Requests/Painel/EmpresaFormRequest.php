<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaFormRequest extends FormRequest
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
            
            'nome' => 'required|min:3|max:100',
            
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.min'      => 'O nome não pode  ter menos de 3 cararteres!',
            'nome.max'      => 'O nome não pode  ter mais de 100 cararteres!'
        ];
    }
}
