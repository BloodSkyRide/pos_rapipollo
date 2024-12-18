<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

use App\Models\modelInventario;
use App\Models\modelProducts;
use App\Models\modelCompuesto;

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


        $insert_product = modelProducts::insertProduct($data);


        foreach ($array as $compuesto) {

            $nombre_inventory = $compuesto["item_inventario"];
            $id_item_inventory = $compuesto["id_item"];
            $discount = $compuesto["input_descuento"];

            $insert_data = ["id_producto_venta" => $insert_product, "nombre_compuesto" => $nombre_inventory, "id_item_fk" => $id_item_inventory,  "descuento" => $discount, "fecha_creacion" => $hoy];

            $insert_compound = modelCompuesto::insertCompound($insert_data);

            
        }


        return response()->json(["status" => true]);
        
        
    }

    public function getShowStore(){

        $render = view("menuDashboard.store")->render();

        return response()->json(["status" => true, "html" => $render]);

    }

    public function getSearch(Request $request){

        $search_text = $request->search_text;

        $search = modelProducts::searcher($search_text);

        $render = view("menuDashboard.searcherTemplate", [ "productos" => $search])->render();

        return response()->json(["status" => true, "html" => $render]);

    }

    public function sell(Request $request){

        $array = $request->data;
        $aux = 0;

        
        foreach($array as $item){
            $aux++;
            $get_compuesto = modelCompuesto::getComposed($item['id_item']);
            $decrement = $item['cantidad'];

            foreach($get_compuesto as $compuesto){

                
                $id_item_fk = $compuesto['id_item_fk']; 
                modelInventario::decrementInventory($id_item_fk, $decrement);

            }

        }

        return ($aux === count($array)) ? response()->json(["status" => true]) : response()->json(["status" => false]);
    }

}
