<?php
namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


Trait trait_helpers{
    public function FechaTimestamp(){
        return Carbon::now()->format("Y-m-d h:i:s");
    }

    private function isFrontend($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }

	public function responseJson($response, $codigoHttp, $headers = array()){
		return response()->json([
			'msg' => $response
		], $codigoHttp, $headers);
    }
    
    protected function clearTokensActivos(User $usuario){
        $userTokens = $usuario->tokens;

        foreach($userTokens as $token) {
            $token->revoke();
        }
    }

    public function returnExpresionesRegulares($opcion){
        $e = "";

        switch($opcion){
            case "NombresApellidos":
                //validar que el nombre no contenga numeros
                $e = '/^[\pL\s\-]+$/u';
            break;

            case "CaracteresPassword":
                //validar que el Campo Clave tenga como mínimo 6 caracteres, máximo 16 y que solo soporte estos caracteres (*.#?¿ )
                $e = '/^([A-Za-z\d\*\.\#\?\¿]){'.User::MIN_CLAVE.','.User::MAX_CLAVE.'}$/i';
            break;
        }
        return $e;
    }

    public function usuarioId(){
        $modeloUser = Auth::user();

        return $modeloUser->id;
    }

    /**
     * @param $booleanController | es para activar el log, desde el controlador
     * @param $log | es el log a guardar
     * @param $stop | detiene el script
     * @param $print | para mostrar el log
     * @param $typeSave | es el tipo de almacenamiento del log
     */
    public function saveLog($booleanController, $log, $stop = false, $print = false, $typeSave = "jsonLog"){
        if($booleanController){
            switch($typeSave){
                case "jsonLog":
                    if($print){
                        \Log::info(json_encode($log));
                    }
                break;

                case "errorLog":
                    \Log::error($log);
                break;
            }

            if($stop === true){
                exit();
            }
        }
    }

    public function authorizationUser(){
        if(!Gate::allows('permiso-admin')){
            throw new AuthorizationException('Acción no permitida.');
        }
    }
}