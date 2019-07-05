<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class Itens_VendaFormRequest extends FormRequest
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
            
            'preco' => 'required',
            // 'quilo' => 'required|numeric',
            'quilo' => 'required',
            
        ];
    }

    public function messages(){
        return [
            'preco.required' => 'O campo preco é obrigatório!',

            'quilo.required' => 'O campo quilo é obrigatório!',
            // 'quilo.numeric'  => 'O quilo só pode conter numeros!',    


        ];
    }
}
