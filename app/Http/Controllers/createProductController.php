<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

use App\Models\modelInventario;

class createProductController extends Controller
{
    public function createProducts(Request $request){

        $productos_inventario = modelInventario::getAllProducts();
        $render = view("menuDashboard.createProduct", ["productos" => $productos_inventario])->render();

        return response()->json([ "status" => true, "html" => $render]);


    }
}
