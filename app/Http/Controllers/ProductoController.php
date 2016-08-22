<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Producto;
use Illuminate\Database\DatabaseManager;
use DB;
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $productos = Producto::paginate(10);
      if($request->ajax()){
        return response()->json(view('conproducto',compact('productos'))->render());
      }else{

        return view('conproducto',compact('productos'));
      }
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
    public function store(Request $request, Producto $producto)
    {
      /*$mensages[
      'codigo' => 'required|unique:productos',
      'nombre' => 'required|unique:productos',
      'und'    => "required",
      'stock'  => "required"
      ];*/
      /*$rules[
        'codigo' => 'required|unique:productos|max:255',
        'nombre' => 'required'
      ];*/
      $validator = Validator::make($request->all(), [
        'codigo' => 'required|unique:productos',
        'nombre' => 'required|unique:productos',
        'und'    => "required",
        'stock'  => "required"
      ],[
        'codigo.required' => 'Se requiere un codigo',
        'nombre.required' => 'Se requiere un nombre',
        'codigo.unique'   => 'El codigo debe ser unico',
        'nombre.unique'   => 'El nombre debe ser unico',
        'und.required'    => 'Debe tener una unidad',
        'stock.required'  => 'Debe tener una existencia'
      ]);

        if ($validator->fails()) {
          return response()->json([$validator->messages()]);
        }else {
          Producto::create($request->all());
          return response()->json([$request->all()]);
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
     public function edit(Request $request, $id)
     {
       $producto = Producto::find($id);
       return response()->json($producto);
       if($request->ajax()){
         return response()->json([$producto]);
       }
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
      $producto = Producto::find($id);
      $producto->fill($request->all());
      $producto->save();
      return response()->json(["mensaje" => "listo"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Producto::destroy($id);
        return response()->json(["mensaje"=>"borrado"]);
    }

    public function listar(){
      $productos = DB::table('productos')
                  ->select('codigo','nombre')
                  ->get();
      dd($productos);
    }


    public function search(Producto $producto, $dato, $tipo){
      if(empty($dato)){
        return response()->json([0]);
      }
      if($tipo==1){
        $producto1 = Producto::where('codigo','=',$dato)->first();

        if(empty($producto1)){
          return response()->json([0]);
        }
        return response()->json([$producto1]);
      }else{
        $producto1 = Producto::where('nombre','=',$dato)->first();

        if(empty($producto1)){
          return response()->json([0]);
        }

        return response()->json([$producto1]);
      }

  }
}
