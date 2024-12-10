<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelInventario extends Model
{

    use HasFactory;
    protected $table = "inventario";
    protected $fillable = [ "id_item", "nombre", "unidades_disponibles", "fecha_creacion", "hora_creacion", "tope_min",
    
    "abastecimiento", "estado", "created_at", "updated_at"];


    public static function createProduct($data){

        return self::insert($data);

    }

    public static function getAllProducts(){

        return self::all();

    }
}
