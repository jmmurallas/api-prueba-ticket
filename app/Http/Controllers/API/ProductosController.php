<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Productos;
use App\Http\Controllers\API\BaseController as BaseController;

class ProductosController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $productos = Productos::all();

        return $this->sendResponse($productos, 'Listado de Productos');

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
            'prodesc' => 'required',
            'provalor' => 'required',            
        ]);

        if($validator->fails()) {
            return $this->sendError("Error de validación.", $validator->errors());
        }

        $producto = new Productos;
        $producto->prodesc = $input["prodesc"];
        $producto->provalor = $input["provalor"];           
        $producto->save();

        return $this->sendResponse($producto, 'Producto Registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $producto = Productos::findOrFail($id);

        if (is_null($producto)) {

            return $this->sendError('Producto No Encontrado');

        }

        return $this->sendResponse($producto, 'Producto Registrado');

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

        $validator = Validator::make($input, [
            'prodesc' => 'required',
            'provalor' => 'required',            
        ]);

        if($validator->fails()) {
            return $this->sendError("Error de validación.", $validator->errors());
        }

        $producto = Productos::findOrFail($id);
        $producto->prodesc = $input["prodesc"];
        $producto->provalor = $input["provalor"];           
        $producto->save();

        return $this->sendResponse($producto, 'Producto Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Productos::findOrFail($id)->delete();    

        return $this->sendResponse($producto, 'Producto Eliminado');
    }
}
