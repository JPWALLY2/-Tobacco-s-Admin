<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class InstrutorFormRequest extends FormRequest
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
            'email' => 'required|min:3|max:100',
            // 'telefone' => 'required|min:8|numeric',
            'telefone' => 'required|min:8',
        ];
    }
    public function messages(){
        return [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.min'      => 'O nome não pode  ter menos de 3 cararteres!',
            'nome.max'      => 'O nome não pode  ter mais de 100 cararteres!',

            'email.required' => 'O campo email é obrigatório!',
            'email.min'      => 'O email não pode  ter menos de 3 cararteres!',
            'email.max'      => 'O email não pode  ter mais de 100 cararteres!',

            'telefone.required' => 'O campo telefone é obrigatório!',
            // 'telefone.numeric'      => 'O telefone só pode conter numeros!',
            'telefone.min'      => 'O telefone não pode  ter menos de 8 cararteres e só pode conter numeros!',

        ];
    }
}
