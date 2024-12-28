<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelFoodEmployee extends Model
{
    use HasFactory;

    protected $table = "comidas_empleados";
    protected $fillable = ["id_registro","nombre_cajero", "cedula", "nombre_empleado", "unidades","item_producto", "fecha", "created_at", "updated_at"];


    public static function insertsData($data){


        return self::insert($data);
    }



    public static function getRegisterActual($fecha){

        return self::where("fecha",$fecha)
        ->get();
    }
}
