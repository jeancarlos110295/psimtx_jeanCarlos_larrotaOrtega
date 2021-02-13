<?php

namespace App\Http\Requests;

use App\Traits\trait_helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class RequestUsers extends FormRequest
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
            "name" => "required",
            "email" => "required|email|unique:App\Models\User,email",
            "password" => "required|min:".User::MIN_CLAVE."|max:".User::MAX_CLAVE."|confirmed|regex:".$this->returnExpresionesRegulares('CaracteresPassword')
        ];
    }

    public function messages(){
        $return = [];

        $return["name.required"] = "El campo Nombre de Usuario, es obligatorio.";

        $return["email.email"] = "El campo E-mail, es invalido.";
        $return["email.required"] = "El campo E-mail, es obligatorio.";
        $return["email.unique"] = "El campo E-mail, ya se encuentra registrado.";

        $return["password.required"] = "El campo Clave, es obligatorio.";
        $return["password.min"] = "El campo Clave, debe ser mayor a ".User::MIN_CLAVE." caracteres.";
        $return["password.max"] = "El campo Clave, supera el máximo de ".User::MAX_CLAVE." caracteres permitidos.";
        $return["password.confirmed"] = "El campo Clave, no es igual al campo de Confirmacion de Clave.";
        $return["password.regex"] = "El campo Clave, es invalido, caracteres permitidos (*.#?¿).";

        return $return;
    }
}
