<?php

use App\Http\Controllers\API\PedidosController;
use App\Http\Controllers\API\ProductosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UsuariosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group(function (){

    //Grupo Usuarios
    Route::prefix('usuarios')->group(function () {

        // RESOURCES        
        Route::resource('usuarios', UsuariosController::class);
        Route::resource('productos', ProductosController::class);    
        Route::resource('pedidos', PedidosController::class);        

    });

    //
    Route::post('logout', [RegisterController::class, 'logout']);

});