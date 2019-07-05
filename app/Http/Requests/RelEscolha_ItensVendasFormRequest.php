<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelEscolha_ItensVendasFormRequest extends FormRequest
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
            // 'dataIni' => 'required',
            // 'dataFin' => 'required',
            // 'empresas_id' => 'required',
        ];
    }

    public function messages(){
        return [
            // 'dataIni.required' => 'O campo data inicial é obrigatório!',
            // 'dataFin.required' => 'O campo data final é obrigatório!',
            // 'empresas_id.required' => 'O campo empresas é obrigatório!',

        ];
    }
}
