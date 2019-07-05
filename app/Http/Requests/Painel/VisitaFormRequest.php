<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class VisitaFormRequest extends FormRequest
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
            'motivo' => 'required|min:3|max:100',
            'observacao' => 'max:500'
        ];
    }

    public function messages(){
        return [
            'motivo.required' => 'O campo motivo é obrigatório!',
            'motivo.min'      => 'O motivo não pode  ter menos de 3 cararteres!',
            'motivo.max'      => 'O motivo não pode  ter mais de 100 cararteres!',

            'observacao.max'      => 'A observacao não pode  ter mais de 100 cararteres!'
        ];
    }
}
