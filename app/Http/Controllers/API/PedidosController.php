<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, DB;
use App\Models\Pedidos;
use App\Http\Controllers\API\BaseController as BaseController;

class PedidosController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = DB::table('pedidos')
                        ->join('productos', 'pedidos.pedpro', '=', 'productos.proid')
                        ->join('usuarios', 'pedidos.pedusu', '=', 'usuarios.id')
                        ->select('productos.prodesc as producto', 'usuarios.usunombre as usuario', 'pedidos.pedvrunit as vlr_uni', 'pedidos.pedcant as cantidad', 'pedidos.*')
                        ->get();

        return $this->sendResponse($pedidos, 'Listado de Pedidos');
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
            'pedpro' => 'required',
            'pedvrunit' => 'required',  
            'pedcant' => 'required',
            'pedsubtot' => 'required',
            'pediva' => 'required',
            'pedtotal' => 'required'
        ]);

        if($validator->fails()) {
            return $this->sendError("Error de validación.", $validator->errors());
        }

        $pedido = new Pedidos;
        $pedido->pedpro = $input["pedpro"];
        $pedido->pedvrunit = $input["pedvrunit"];      
        $pedido->pedcant = $input["pedcant"];   
        $pedido->pedsubtot = $input["pedsubtot"];   
        $pedido->pediva = $input["pediva"];        
        $pedido->pedtotal = $input["pedtotal"];   
        $pedido->pedusu = auth()->user()->id;   
        $pedido->save();

        return $this->sendResponse($pedido, 'Pedido Registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedidos = DB::table('pedidos')
                        ->join('productos', 'pedidos.pedpro', '=', 'productos.proid')
                        ->join('usuarios', 'pedidos.pedusu', '=', 'usuarios.id')
                        ->select('productos.prodesc as producto', 'usuarios.usunombre as usuario', 'pedidos.pedvrunit as vlr_uni', 'pedidos.pedcant as cantidad', 'pedidos.pedid')
                        ->where('pedidos.pedid', '=', $id)
                        ->get();

        return $this->sendResponse($pedidos, 'Listado de Pedidos');
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
            'pedpro' => 'required',
            'pedvrunit' => 'required',  
            'pedcant' => 'required',
            'pedsubtot' => 'required',
            'pediva' => 'required',
            'pedtotal' => 'required'
        ]);

        if($validator->fails()) {
            return $this->sendError("Error de validación.", $validator->errors());
        }

        $pedido = Pedidos::findOrFail($id);
        $pedido->pedpro = $input["pedpro"];
        $pedido->pedvrunit = $input["pedvrunit"];      
        $pedido->pedcant = $input["pedcant"];   
        $pedido->pedsubtot = $input["pedsubtot"];   
        $pedido->pediva = $input["pediva"];        
        $pedido->pedtotal = $input["pedtotal"];   
        $pedido->pedusu = auth()->user()->id;   
        $pedido->save();

        return $this->sendResponse($pedido, 'Pedido Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedidos = Pedidos::findOrFail($id)->delete();    

        return $this->sendResponse($pedidos, 'Pedido Eliminado');
    }

}
