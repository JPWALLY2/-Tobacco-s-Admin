<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimativaFormRequest extends FormRequest
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
            // 'quant' => 'required|min:10000',
            'quant' => 'required',
            'media' => 'required',
            'arroba' => 'required',
            'valorInsumo' => 'required',
        ];
    }

    public function messages(){
        return [
            'quant.required' => 'A quantidade é obrigatório!',
            // 'quant.min' => 'O valor deve ser maior que 10.000,00!',

            'media.required' => 'A média é obrigatório!',

            'arroba.required' => 'O número de arrobas é obrigatório!',

            'valorInsumo.required' => 'O valor dos insumos é obrigatório!',
        ];
    }
}
