<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class PlantacaoFormRequest extends FormRequest
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
            'quant' => 'required',
            'observacao' => 'max:500'
        ];
    }

    public function messages(){
        return [
            'quant.required' => 'O campo quantidade é obrigatório!',

            'observacao.max'      => 'A observacao não pode  ter mais de 100 cararteres!'
        ];
    }
}
