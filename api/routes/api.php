<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\ControllerAuthUser;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ControllerIntereses;


Route::get('testApi', function(){
    return response()->json([
        'ipCliente' => request()->ip()
    ]);
});


Route::prefix('Usuarios')->group(function(){
    Route::post("store", [ControllerAuthUser::class , "store"]);
    Route::get("index", [LoginController::class , "index"]);
    Route::get("indexPublico", [LoginController::class , "indexPublico"]);
    Route::post("updateClave", [LoginController::class , "updateClave"]);
    Route::post("updateEstado", [LoginController::class , "updateEstado"]);
});

Route::prefix('Auth')->group(function(){
    Route::post('login', [ControllerAuthUser::class, "loginUser"]);
    Route::get('logout',  [LoginController::class, "logoutUser"]);
});

Route::prefix("Intereses")->group(function(){
    Route::get('index', [ControllerIntereses::class, "index"]);
    Route::get('view/{id}', [ControllerIntereses::class, "view"]);
    Route::post('store', [ControllerIntereses::class, "store"]);
    Route::put('update/{id}', [ControllerIntereses::class, "update"]);
    Route::delete('delete/{id}', [ControllerIntereses::class, "delete"]);
    Route::post('interesesSimilares', [ControllerIntereses::class, 'interesesSimilares']);
});