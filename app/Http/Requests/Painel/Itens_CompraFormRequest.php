<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class Itens_CompraFormRequest extends FormRequest
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
            'quant' => 'required|min:1|max:500|numeric',
            
        ];
    }

    public function messages(){
        return [
            'preco.required' => 'O campo preco é obrigatório!',

            'quant.required' => 'O campo quantidade é obrigatório!',
            'quant.numeric'  => 'A quantidade só pode conter numeros!',            
            'quant.min'      => 'A quantidade não pode ser menor de 1!',
            'quant.max'      => 'A quantidade não pode ser maior de 500!'


        ];
    }
}