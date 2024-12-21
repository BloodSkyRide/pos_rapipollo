<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Js;
use Carbon\Carbon;
use App\Models\modelInventario;
use App\Models\modelProducts;
use App\Models\modelCompuesto;
use App\Models\modelSell;
use App\Models\modelAssits;
use Tymon\JWTAuth\Facades\JWTAuth;

class createProductController extends Controller
{
    public function createProducts(Request $request)
    {

        $productos_inventario = modelInventario::getAllProducts();
        $render = view("menuDashboard.createProduct", ["productos" => $productos_inventario])->render();

        return response()->json(["status" => true, "html" => $render]);
    }


    private function saveImageProduct($image)
    {

        $file_name = $image->getClientOriginalName();
        $base_name = pathinfo($file_name, PATHINFO_FILENAME);
        $root_path = 'storage/product_images';
        $hoy = Carbon::now()->format('Y-m-d');

        $name_final = $base_name . "_" . $hoy;
        $path = $image->storeAs("product_images", $name_final . ".jpg", "public");
        return $root_path . "/" . $name_final . ".jpg";
    }

    public function saveProduct(Request $request)
    {

        $array = json_decode($request->array, true);
        $nombre = $request->nombre;
        $precio_producto = $request->precio;
        $description = $request->description;
        $hoy = date("Y-m-d");

        $image = $request->image;

        $url_image = self::saveImageProduct($image);



        $data = ["nombre_producto" => $nombre, "precio" => $precio_producto, "descripcion" => $description, "fecha_creacion" => $hoy, "url_imagen" => $url_image];


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

    public function getShowStore(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $rol = $decode_token["rol"];

        $today = date("Y-m-d");
        $state_start = "INICIAR JORNADA LABORAL";
        $state_end = "FINALIZAR JORNADA LABORAL";
        $verify_Assists_start = modelAssits::verifyStartAssist($today, $state_start, $self_id);
        $verify_Assists_end = modelAssits::verifyStartAssist($today, $state_end, $self_id);

        if ($rol !== "administrador") {
            if (count($verify_Assists_start) > 0 && count($verify_Assists_end) < 1 ) {


                $render = view("menuDashboard.store")->render();

                return response()->json(["status" => true, "html" => $render]);
            } else return response()->json(["status" => false]);
        }else{

            $render = view("menuDashboard.store")->render();
            return response()->json(["status" => true, "html" => $render]);

        }
    }

    public function getSearch(Request $request)
    {


        $search_text = $request->search_text;

        $search = modelProducts::searcher($search_text);

        $render = view("menuDashboard.searcherTemplate", ["productos" => $search])->render();

        return response()->json(["status" => true, "html" => $render]);
    }

    public function sell(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"] . " " . $decode_token["apellido"];

        $array = $request->data;
        $aux = 0;


        foreach ($array as $item) {
            $aux++;
            $id_producto_venta = $item['id_item'];
            $get_compuesto = modelCompuesto::getComposed($id_producto_venta);

            // data historial

            $data_product = modelProducts::getProduct($id_producto_venta);
            $nombre_producto = $data_product->nombre_producto;
            $descripcion_producto = $data_product->descripcion;
            $precio_producto = $data_product->precio;


            $decrement = $item['cantidad'];

            // historial de ventas

            $hour = date('h:i:s');
            $fecha = date('Y-m-d');

            $total_venta = $decrement * $precio_producto;


            $bandera = 0;

            foreach ($get_compuesto as $compuesto) {

                $descuento = $compuesto['descuento'];
                $descuento_final = $decrement * $descuento;
                $id_item_fk = $compuesto['id_item_fk'];
                modelInventario::decrementInventory($id_item_fk, $descuento_final);
                $bandera++;
            }

            if ($bandera === count($get_compuesto)) {


                $data_sell = [
                    "id_producto_venta" => $id_producto_venta,
                    "nombre_producto_venta" => $nombre_producto,
                    "descripcion_producto_venta" => $descripcion_producto,
                    "unidades_venta" => $decrement,
                    "id_user_cajero" => $self_id,
                    "nombre_cajero" => $self_name,
                    "hora" => $hour,
                    "fecha" => $fecha,
                    "total_venta" => $total_venta
                ];
                modelSell::insertSell($data_sell);
            }
        }

        return ($aux === count($array)) ? response()->json(["status" => true]) : response()->json(["status" => false]);
    }
}
