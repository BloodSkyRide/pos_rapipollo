<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelSubLabores extends Model
{
    use HasFactory;

       protected $table = "sub_labores";
       protected $fillable = ["id_sub_labor", "id_labor", "nombre_sub_labor", "fecha_creacion", "created_at", "updated_at"];

       protected $state_ok = "REALIZADO";

    public static function getSubLabores(){


        return self::all();
    }


    public static function deleteSubLabors($ids){



       return  self::whereIn('id_sub_labor', $ids)->delete();

    }


    public static function addSubLabors($array){

        return self::insert($array);

    }


    public static function getSubLaborsForId($id,$state_pending){

        return self::where('id_labor',$id)
        ->where("estado",$state_pending)
        ->get();

    }


    public static function changeStateSubLabor($id_labor,$nombre_sub_labor,$state){


        self::where("id_labor",$id_labor)
        ->where("nombre_sub_labor",$nombre_sub_labor)
        ->update(["estado" => $state]);

    }


    public static function rechargeSubLabors($ids,$state){


        return self::whereIn("id_sub_labor",$ids)
        ->update(["estado" => $state]);

    }

    public static function getTaskPending($pending){



        return self::where("estado",$pending)
        ->select("nombre_sub_labor")
        ->get();
    }

    public static function changeState($pending,$unrealized){



        return self::where("estado",$pending)
        ->update(["estado" => $unrealized]);
    }
}
