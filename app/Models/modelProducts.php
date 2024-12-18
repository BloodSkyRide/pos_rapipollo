<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelProducts extends Model
{

    use HasFactory;

    protected $table = "productos_venta";
    protected $fillable = ["nombre_producto","precio", "fecha_creacion", "created_at", "updated_at" ];

    public static function insertProduct($data){


        return self::create($data)->id; // se debe

    }

    public static function searcher($search_text){

        return self::where("nombre_producto","LIKE", "%". $search_text. "%")
        ->limit(5)
        ->get();

    }
}
