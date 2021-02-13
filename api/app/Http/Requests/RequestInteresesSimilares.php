<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestInteresesSimilares extends FormRequest
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
            "interes" => "required|array"
        ];
    }

    public function messages()
    {
        return [
            "interes.required" => "No se han seleccionado intereses.",
            "interes.array" => "El campo Interes, debe ser un arreglo, con los identificadores de los intereses seleccionados.",
        ];
    }
}
