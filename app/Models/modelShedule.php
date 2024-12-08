<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class modelShedule extends Model
{
    use HasFactory;
    protected $table = "horarios";
    protected $fillable = ["id_horario", "id_user", "nombre", "apellido", "lunes", "aseo-lunes",
     "martes", "aseo-martes", "miercoles","aseo-miercoles", "jueves","aseo-jueves", "viernes","aseo-viernes",
      "sabado","aseo-sabado", "domingo","aseo-domingo", "created_at", "updated_at"];


    public static function insertSchedule($id_user, $dia, $shedule)
    {


        return self::where("id_user", $id_user)
            ->update([$dia => $shedule]);
    }


    public static function getShowSchedule()
    {


        return self::rightJoin("users", "horarios.id_user", "=", "users.cedula")
            ->select(
                "users.cedula as cedula",
                "users.nombre as nombre",
                "users.apellido as apellido",
                "horarios.lunes",
                "horarios.aseo-lunes",
                "horarios.martes",
                "horarios.aseo-martes",
                "horarios.miercoles",
                "horarios.aseo-miercoles",
                "horarios.jueves",
                "horarios.aseo-jueves",
                "horarios.viernes",
                "horarios.aseo-viernes",
                "horarios.sabado",
                "horarios.aseo-sabado",
                "horarios.domingo",
                "horarios.aseo-domingo"
            )
            ->get();
    }



    public static function insertLV($id_user,$data){

        return self::where("id_user" , $id_user)
        ->update($data);

    }


    public static function insertids($id_user){ //script para actualizar los registros de horarios de cada usuario, solo se debe hacer uso una vez

        return self::insert(["id_user" => $id_user]);

    }

    public static function editClear($id_user, $dia){

        return self::wherer("id_user", $id_user)
        ->update([ $dia => null]);

    }
}
