<?php

namespace App\Http\Controllers\Auth;

session_start();

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\File;
use App\Models\IpBloqueadas;
use Illuminate\Http\Request;
use App\Traits\trait_helpers;
use App\Http\Requests\RequestAuth;
use App\Http\Requests\RequestUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ResourceUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ControllerAuthUser extends Controller
{
    use trait_helpers;
    
    const MaxAttemps = 3; //cantidad máxima de intentos permitidos. maxAttempts
    const SUPER_LOG = true;

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function store(RequestUsers $request)
    {
        $request["password"] = User::encrypPassword($request->input("password"));
        $request["rol"] = User::ROL_USER;

        try{
            User::create($request->all());

            return $this->responseJson("Usuario Creado.", 200);
        }catch (Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al registrar.", 500);
        }
    }

    public function loginUser(RequestAuth $request){
        $auth = [
            "email" => $request->input("email"),
            "password" => $request->input("password")
        ];

        Auth::attempt($auth);

        if(Auth::check()):
            $userAuth = Auth::user();

            $this->clearTokensActivos($userAuth);
            
            if($userAuth->bloqueado == "true"){
                return $this->responseJson("Usuario Bloqueado.", 401);
            }

            if(is_null($userAuth->verification_token)){
                $token = array(
                    'token' => $userAuth->createToken($userAuth->email)->accessToken,
                    'user' => array(
                        //'id_user' => $userAuth->id,
                        'rol' => $userAuth->rol,
                        'UserName' => $userAuth->name,
                    )
                );

                return $this->responseJson($token, 200);
            }else{
                return $this->responseJson("Error al iniciar sesión, vuelve a intentar.", 500);
            }
        endif;
    }
}
