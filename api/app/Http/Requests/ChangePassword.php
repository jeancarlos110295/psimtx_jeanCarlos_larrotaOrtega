<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\trait_helpers;
use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
{
    use trait_helpers;

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
            "password" => "required|min:".User::MIN_CLAVE."|max:".User::MAX_CLAVE."|confirmed|regex:".$this->returnExpresionesRegulares('CaracteresPassword')
        ];
    }

    public function all($keys = null)
    {
        $inputs = $this->input();

        if((int)$this->input("identificador") == 0){
            $inputs["identificador"] = "";
        }

        return $inputs;
    }

    public function messages()
    {
        $return = [];

        $return["identificador.required"] = "EL campo Identificador no viene en la petición.";

        $return["password.required"] = "El campo Clave, es obligatorio.";
        $return["password.min"] = "El campo Clave, debe ser mayor a ".User::MIN_CLAVE." caracteres.";
        $return["password.max"] = "El campo Clave, supera el máximo de ".User::MAX_CLAVE." caracteres permitidos.";
        $return["password.confirmed"] = "El campo Clave, no es igual al campo de Confirmacion de Clave.";
        $return["password.regex"] = "El campo Clave, es invalido, caracteres permitidos (*.#?¿).";

        return $return;
    }
}
