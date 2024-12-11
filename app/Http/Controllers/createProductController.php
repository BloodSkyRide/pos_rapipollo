<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

use App\Models\modelInventario;
use App\Models\modelProducts;

class createProductController extends Controller
{
    public function createProducts(Request $request){

        $productos_inventario = modelInventario::getAllProducts();
        $render = view("menuDashboard.createProduct", ["productos" => $productos_inventario])->render();

        return response()->json([ "status" => true, "html" => $render]);


    }

    public function saveProduct(Request $request){

        $array = $request->array;
        $nombre = $request->nombre;
        $precio_producto = $request->precio;
        $hoy = date("Y-m-d");
        $data = ["nombre_producto" => $nombre, "precio" => $precio_producto, "fecha_creacion" => $hoy];


        $insert = modelProducts::insertProduct($data);

        dd($insert);
        
    }
}
