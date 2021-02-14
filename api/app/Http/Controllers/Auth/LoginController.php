<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\trait_helpers;
use App\Http\Requests\ChangeEstado;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ChangePassword;
use App\Http\Resources\ResourceUsers;
use App\Http\Resources\ResourceIndexPublico;


class LoginController extends Controller
{
    use trait_helpers;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function logoutUser(){
        try{
            $this->clearTokensActivos(Auth::user());

            return $this->responseJson("Sesión cerrada.", 200);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al cerrar sesión.", 500);
        }
    }

    public function index(){
        $this->authorizationUser();

        try{
            return ResourceUsers::collection(User::all());
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al retornar la lista de usuarios.", 500);
        }
    }

    public function indexPublico(){
        try{
            $users = User::select(
                "id as identificador",
                "name as nombre"
            )->where("rol", "=", User::ROL_USER)->get();
            return ResourceIndexPublico::collection($users);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al retornar la lista de usuarios.", 500);
        }
    }

    public function updateClave(ChangePassword $request){
        $this->authorizationUser();

        $id = $request->input("identificador");
        $password = $request->input("password");

        try{
            $user = User::findOrFail($id);
            $user->password = User::encrypPassword($password);
            $user->save();

            return $this->responseJson("Clave actualizada.", 200);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al actualizar la clave.", 500);
        }
    }

    public function updateEstado(ChangeEstado $request){
        $this->authorizationUser();

        $id = $request->input("identificador");
        $estado = ($request->input("estado") == 0) ? "false" : "true";

        try{
            $user = User::findOrFail($id);
            $user->bloqueado = $estado;
            $user->save();

            return $this->responseJson("Estado actualizado.", 200);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al actualizar el estado.", 500);
        }
    }
}
