<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\trait_helpers;
use Illuminate\Foundation\Http\FormRequest;

class RequestAuth extends FormRequest
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
            "email" => "required|email",
            "password" => "required|min:".User::MIN_CLAVE."|max:".User::MAX_CLAVE."|regex:".$this->returnExpresionesRegulares('CaracteresPassword')
        ];
    }

    public function messages()
    {
        $return = [];

        $return["email.email"] = "El campo E-mail, es invalido.";
        $return["email.required"] = "El campo E-mail, es obligatorio.";

        $return["password.required"] = "El campo Clave, es obligatorio.";
        $return["password.min"] = "El campo Clave, debe ser mayor a ".User::MIN_CLAVE." caracteres.";
        $return["password.max"] = "El campo Clave, supera el máximo de ".User::MAX_CLAVE." caracteres permitidos.";
        $return["password.regex"] = "El campo Clave, es invalido, caracteres permitidos (*.#?¿).";

        return $return;
    }
}
