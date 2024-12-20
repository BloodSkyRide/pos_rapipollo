<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelSell extends Model
{
    use HasFactory;
    protected $table = "historial_ventas";
    protected $fillable = ["id_producto_venta", "nombre_producto_venta", "descripcion_producto_venta", 
    "unidades_venta", "id_user_cajero", "nombre_cajero", "hora", "fecha", "total_venta", "created_at", "updated_at"];

    public static function insertSell($data){

        return self::insert($data);

    }

    public static function getSells($fecha){


        return self::where("fecha", $fecha)
        ->orderby("fecha", "desc")
        ->get();


    }


    public static function totalSells($fecha){

        return self::where("fecha", $fecha)
        ->sum('total_venta');

    }
}
