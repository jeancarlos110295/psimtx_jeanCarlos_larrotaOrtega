<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Intereses;
use Illuminate\Http\Request;
use App\Traits\trait_helpers;
use App\Models\RelInteresesUser;
use App\Http\Requests\RequestInteres;
use App\Http\Resources\ResourceIntereses;
use App\Http\Resources\ResourceIndexPublico;
use App\Http\Requests\RequestInteresesSimilares;

class ControllerIntereses extends Controller
{
    use trait_helpers;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $this->authorizationUser();

        try{
            return ResourceIntereses::collection(Intereses::all());
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al retornar la lista de intereses.", 500);
        }
    }

    public function indexPublico(){
        try{
            $intereses = Intereses::select(
                'id as identificador',
                'interes'
            )->get();

            return ResourceIndexPublico::collection($intereses);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");

            return $this->responseJson("Error al retornar la lista de intereses.", 500);
        }
    }

    public function view($id){
        $this->authorizationUser();
        $id = (int)$id;

        try{
            $interes = Intereses::findOrFail($id);
            return new ResourceIntereses($interes);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");
            return $this->responseJson("Error al mostrar el interes seleccionado.", 500);
        }
    }

    public function store(RequestInteres $request){
        $this->authorizationUser();

        try{
            Intereses::create([
                "interes" => $request->input("interes")
            ]);
            return $this->responseJson("Se ha agregado un nuevo interes.", 200);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");
            return $this->responseJson("Error al guardar el interes.", 500);
        }
    }

    public function update(Request $request,$id){
        $this->authorizationUser();
        
        $id = (int)$id;

        try{
            $interes = Intereses::findOrFail($id);
            $interes->interes = $request->input("interes");
            $interes->save();

            return $this->responseJson("Interes actualizado.", 200);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");
            return $this->responseJson("Error al actualizar el interes seleccionado.", 500);
        }
    }

    public function delete($id){
        $this->authorizationUser();
        $id = (int)$id;

        try{
            $interes = Intereses::findOrFail($id);
            
            $interes->delete();

            return $this->responseJson("Interes eliminado.", 200);
        }catch(Exception $e){
            $this->saveLog(true, $e->getMessage(), false, true, "errorLog");
            return $this->responseJson("Error al eliminar el interes seleccionado.", 500);
        }
    }

    public function interesesSimilares(RequestInteresesSimilares $request){
        $intereses = $request->input("interes");

        $intereses = array_unique($intereses);

        if(count($intereses) <= 5){
            $usersInteresSimilar = array();

            //1) Eliminar los intereses asociados al usuario, si llega a tener
            foreach($intereses as $interes){

                $buscarInteresUser = RelInteresesUser::where("id_interes", "=", $interes)
                    ->where("id_usuario", "=", $this->usuarioId())
                    ->get()
                    ->first();
                
                // 2) Se registra la relacion en caso de que no exista
                if(is_null($buscarInteresUser)){
                    RelInteresesUser::create([
                        "id_usuario" => $this->usuarioId(),
                        "id_interes" => $interes
                    ]);
                }

                $buscarInteresSimilar = RelInteresesUser::select(
                    "rel_intereses_user.id_usuario",
                    "rel_intereses_user.id_interes",
                    //"users.name",
                    "intereses.interes"
                )
                    //->join("users" , "users.id" , "=", "rel_intereses_user.id_usuario")
                    ->join("intereses", "intereses.id", "=", "rel_intereses_user.id_interes")
                    ->where("rel_intereses_user.id_interes", "=", $interes)
                    ->where("rel_intereses_user.id_usuario", "!=", $this->usuarioId())
                    ->get();
                
                if(!is_null($buscarInteresSimilar) && $buscarInteresSimilar->count() > 0){
                    foreach($buscarInteresSimilar as $data){
                        $usersInteresSimilar[$data->id_usuario][] = array(
                            "interes" => $data->interes
                        );
                    }
                }
            }

            return $this->responseJson($usersInteresSimilar, 200);
        }else{
            return $this->responseJson("No se pueden seleccionar mas de 5 intereses.", 500);
        }
    }
}
