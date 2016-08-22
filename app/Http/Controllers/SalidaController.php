<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Movimiento;
use App\Producto;
use DB;
use Validator;

class SalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $salidas = DB::table('movimientos')->where('tipo_mov','=',0)->paginate(10);
        return view('consalida', ['salidas' => $salidas]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request, Movimiento $producto)
     {
       /*
       Salida: 0
       Entrada:1
       */

       if($request->ajax()){

         $validator = Validator::make($request->all(), [
           "codigo" => "required",
           "cantidad" => "required"
         ],[
           "codigo.required" => "Se requiere un codigo",
           "cantidad.required" => "Se requiere una cantidad"
          ]);

         if ($validator->fails()) {
           return response()->json([$validator->messages()]);
         }else {
           $movimiento = new Movimiento;
           $movimiento->codigo = $request->codigo;
           $movimiento->cantidad = $request->cantidad;
           $movimiento->dpto = $request->dpto;
           $movimiento->receptor = $request->receptor;
           $movimiento->fecha = $request->fecha;
           $movimiento->tipo_mov = 0;
           $movimiento->save();

           $producto = Producto::where('codigo',$request->codigo)->first();
           $existencia = $producto->stock - $request->cantidad;
           $producto->stock = $existencia;
           $producto->save();

           return response()->json([$existencia]);
        }
       }else{
         return response()->json(["menssage" => "datos no recibidos mediante ajax"]);
       }

     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $producto = DB::table('movimientos')
                  ->where('id','=',$id)
                  ->first();
      return response()->json($producto);
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
      dd($id);
      /*$producto = Producto::find($id);
      $producto->fill($request->all());
      $producto->save();
      return response()->json(["mensaje" => "listo"]);*/
    }

    public function mostrar(){
      $data = DB::table('productos')
                    ->select('id','nombre')
                    ->get();
      return view('regsalida', ['data' => $data]);
    }
    public function select_sal(Producto $producto, Request $request, $id){

      $producto1 = $producto->findOrFail($id);
      return response()->json([$producto1]);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
        Movimiento::destroy($id);
        return response()->json(["mensaje"=>"borrado"]);
     }
}
