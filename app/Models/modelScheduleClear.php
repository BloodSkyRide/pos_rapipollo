<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelScheduleClear extends Model
{
    use HasFactory;

    protected $table = "horarios";
    protected $fillable = ["id_horario", "id_user", "nombre", "apellido", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo", "created_at", "updated_at"];


    public static function getShowSchedule(){


        return self::all();

    }


    public static function getUserClear($id_user,$dia){
    
        return self::where("id_user", $id_user)
        ->select($dia)
        ->get();
    
    }

    public static function insertScheduleClear($id_user, $dia){

        return self::where("id_user",$id_user)
        ->update([ $dia => true]);

    }


    public static function editClear($id_user, $dia){

        return self::where("id_user", $id_user)
        ->update([ $dia => null]);

    }


}
