<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelOverTime extends Model
{
    use HasFactory;

    protected $fillable = ["id_notificacion", "id_user", "nombre", "apellido", "fecha_solicitud", "hora_solicitud", "hora_inicio", "hora_final", "fecha_notificacion", "motivo", "estado", "created_at", "updated_at"];
    protected $table = "historial_notificaciones";


    public static function insertNotification($data){


        return self::insert($data);

    }


    public static function getAllNotifications(){

        return  self::orderBy("fecha_solicitud", "desc")->get();

    }

    public static function changeState($state,$id_notification){


        return self::where("id_notificacion", $id_notification)
        ->update(["estado" => $state]);

    }


    public static function getId_user($id_notification){


        return self::where("id_notificacion", $id_notification)
        ->select("id_user")
        ->first();

    }


    public static function getMyRequest($id_user, $fecha){


        return self::where('id_user', $id_user)
        ->where('fecha_solicitud', '>', $fecha)
        ->get();

    }


}
