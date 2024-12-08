<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labores extends Model
{
    use HasFactory;



    public static  function getLabores(){


        return labores::all();

    }


    public static function insertLabor($name){


        return self::insert(["nombre_labor" =>$name]);

    }

    public static function getNameLabor($id_labor){


        return self::where("id_labor", $id_labor)
        ->select("nombre_labor")
        ->first();
    }


    public static function modifyName($id_labor, $name){

        return  self::where("id_labor", $id_labor)
        ->update(["nombre_labor" => $name]);


    }
}
