<?php

namespace App\Http\Controllers;
use App\Models\modelInventario;
use Illuminate\Http\Request;

class inventoryController extends Controller
{
    

    public function getShowInventory(Request $request){

        $productos_inventario = modelInventario::getAllProducts();
        $total_inventory = modelInventario::getTotalInventory();


        $render = view("menuDashboard.inventory", ["productos" => $productos_inventario,"total" => $total_inventory])->render();

        return response()->json(["status" => true, "html" => $render]);

    }

    public function saveInventory(Request $request){

        $nombre_producto = $request->nombre_producto;
        $unidades = $request->unidades;
        $tope_min = $request->tope_min;
        $precio_costo = $request->precio_costo;

        $fecha = date("Y-m-d");
        $hour = date('h:i:s');
        
        $data_inventory = ["nombre" => $nombre_producto, "unidades_disponibles" => $unidades, "fecha_creacion" => $fecha, "hora_creacion" => $hour, "tope_min" => $tope_min,
        "abastecimiento" => "ABASTECIDO", "precio_costo" => $precio_costo, "estado" => "DISPONIBLE"];

        $insert_product_inventory = modelInventario::createProduct($data_inventory);

        
        if($insert_product_inventory) return self::getShowInventory($request);
        else return response()->json(["status" => false]);
        
    }


    public function editInventory(Request $request){

        $unidades = $request->unidades;
        $id_inventory = $request->id_inventory;
        $precio_costo = $request->precio_costo;

        if(empty($precio_costo)){
            
            
            $get_units = modelInventario::getUnits($id_inventory)->unidades_disponibles;

            $units_final = $get_units + $unidades;

            $insert_units = modelInventario::insertUnits($id_inventory, $units_final);



        }else{

            $insert = modelInventario::updatePrice($id_inventory, $precio_costo);

        }


        return self::getShowInventory($request);
    }


    public function deleteInventory(Request $request){

        $id_item = $request->id_item_inventory;

        $delete = modelInventario::deleteInventory($id_item);

        if($delete) return self::getShowInventory($request);
        else return response()->json(["status" => false]);

    }
}
