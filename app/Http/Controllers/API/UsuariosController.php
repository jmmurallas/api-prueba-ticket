<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class UsuariosController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return $this->sendResponse($usuarios, 'Listado de Usuarios');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'usunombre' => 'required',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return $this->sendError("Error de validación.", $validator->errors());
        }

        $usuario = new User;
        $usuario->usunombre = $input["usunombre"];
        $usuario->email = $input["email"];
        $usuario->password = bcrypt($input["password"]);        
        $usuario->save();

        return $this->sendResponse($usuario, 'Usuario Registrado');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);

        if (is_null($usuario)) {

          return $this->sendError('Usuario No Encontrado');

        }

        return $this->sendResponse($usuario, 'Usuario Encontrado');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $input = $request->all();

        $validator =  Validator::make($input, [
            'usunombre' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {

            return $this->sendError("Error de validación", $validator->errors());

        }

        $usuario = User::findOrFail($id);
        $usuario->usunombre = $input["usunombre"];

        if($input["email"] != $usuario->email) {
            $usuario->email = $input["email"];
        } 
        
        $usuario->save();

        return $this->sendResponse($usuario, 'Usuario Actualizado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $usuario = User::findOrFail($id)->delete();    

        return $this->sendResponse($usuario, 'Usuario Eliminado');

    }

}
