<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelEscolha_SafrasFormRequest extends FormRequest
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
            'data' => 'required',
        ];
    }

    public function messages(){
        return [
            'data.required' => 'O campo data é obrigatório!',
            // 'data.date_format:Y' => 'O ano não existe',

        ];
    }
}
