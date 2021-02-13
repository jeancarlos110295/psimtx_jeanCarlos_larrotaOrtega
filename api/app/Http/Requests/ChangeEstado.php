<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeEstado extends FormRequest
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
            "identificador" => "required",
            "estado" => "required"
        ];
    }

    public function all($keys = null)
    {
        $inputs = $this->input();

        if((int)$this->input("identificador") == 0){
            $inputs["identificador"] = "";
        }

        $inputs["identificador"] = (int)$this->input("estado");

        return $inputs;
    }

    public function messages()
    {
        $return = [];

        $return["identificador.required"] = "EL campo Identificador no viene en la petición.";
        $return["estado.required"] = "EL campo Estado, es obligatorio.";

        return $return;

    }
}
