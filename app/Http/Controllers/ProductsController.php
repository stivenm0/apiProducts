<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();

        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $respuesta= [];
        $validar = $this->validar($request->all());

        if(!is_array($validar)){
            Products::create($request->all());
            array_push($respuesta, ["status"=>"success"]);
            return response()->json($respuesta);
            
        }else{
            return response()->json($validar);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $respuesta= [];
        $validar = $this->validar($request->all());

        if(!is_array($validar)){
           $product= Products::find($id);

            if($product){
                $product->fill( $request->all())->save();
                array_push($respuesta, ["status"=>"success"]);
                
            }else{
                array_push($respuesta, ["status"=>"error"]);
                array_push($respuesta, ["error"=>"ID no existe"]);
            }
            return response()->json($respuesta);

        }else{
            return response()->json($validar);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $respuesta= [];
        $product = Products::find($id);

        if($product){
            $product->delete();
            array_push($respuesta, ["status"=>"success"]);

        }else{
            array_push($respuesta, ["status"=>"error"]);
            array_push($respuesta, ["error"=>"ID no existe"]);
        }

        return response()->json($respuesta);

    }

    public function validar($params){
        $respuesta = [];
        $message = [
            "max"=>"el campo :attribute NO debe tener más de :max caracteres",
            "required"=>"el campo :attribute NO debe estar vacío",
            "precio.numeric"=>"el precio debe ser numérico"
        ];

        $validacion = Validator::make($params,
        [
            'nombre'=>'required|max:80',
            'descripcion'=>'required|max:150',
            'precio'=>'required|numeric|max:999999'
        ], $message
        );

        if($validacion->fails()){
            array_push($respuesta, ["status"=>'error']);
            array_push($respuesta, ["error"=> $validacion->errors()]);
            
            return $respuesta;
        }else{
            return true;
        }
    }

}
