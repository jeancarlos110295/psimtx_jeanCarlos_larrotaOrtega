<?php

namespace App\Exceptions;

use Exception;
use Throwable;


use App\Traits\trait_helpers;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use trait_helpers;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if($exception instanceof ModelNotFoundException){
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->responseJson('No existe ninguna instancia de {'.$modelo.'} con el id especificado', 404);
        }

        if($exception instanceof AuthenticationException){ 
            return $this->unauthenticated($request, $exception);
        }

        if($exception instanceof AuthorizationException){
            return $this->responseJson("No posee permisos para ejecutar esta accion" , 403);
        }

        if($exception instanceof NotFoundHttpException){
            return $this->responseJson("No se encontro la URL especificada" , 404);
        }

        if($exception instanceof MethodNotAllowedHttpException){
            return $this->responseJson("El metodo especificado en la peticion no es valido" , 405);
        }

        if($exception instanceof HttpException){
            return $this->responseJson($exception->getMessage() , $exception->getStatusCode());
        }


        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }

        if($exception instanceof QueryException){
            $code = $exception->errorInfo[1];

            if($code == 1451){
                return $this->responseJson("No se puede eliminar de forma permanente el recurso porque este esta relacionado con algun otro",409);
            }
        }

        if(config('app.debug')){
            return parent::render($request, $exception);
        }

        return $this->responseJson("Falla Inesperada, intente luego", 500);
    }


    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        if ($this->isFrontend($request)) {
            return $request->ajax() ? response()->json($errors, 422) : redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors($errors);
        }

        return $this->responseJson($errors, 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception){
        return $this->responseJson("No autenticado", 401);
    }
}
