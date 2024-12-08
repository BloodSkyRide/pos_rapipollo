<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class modelAssits extends Model
{
    use HasFactory;
    protected $table = "historial_asistencia";
    protected $fillable = ["id_historial_asistencia","id_user","estado", "fecha", "hora", "created_at", "updated_at"];



    public static function insertHour($data){


        return self::insert($data);


    }


    public static function getMyAssists($id,$fecha){


        return self::where('id_user',$id)
        ->where("fecha",$fecha)
        ->get();

    }


    public static function getAssists(){


        return self::orderBy("id_historial_asistencia", "desc")->limit(20)->get();

    }


    public static function getHour($id_user,$action){


        return self::where("id_user",$id_user)
        ->where("estado", $action)
        ->select("hora")
        ->get();
    }


    public static function getDate($id_user,$action){


        return self::where("id_user",$id_user)
        ->where("estado", $action)
        ->select("fecha")
        ->get();
    }


    public static function secureData($id_user, $state, $hour, $date){


        return self::where("id_user",$id_user)
        ->where("fecha",$date)
        ->where("estado", $state)
        ->update([ "hora" => $hour]);
    }


    public static function getTableEdit($fechaInicio,$fechaFin){


        return DB::table('historial_asistencia')
    ->select('id_user')
    ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA LABORAL' THEN fecha END) AS fecha")
    ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA LABORAL' THEN hora END) AS inicio_labor")
    ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA ALIMENTARIA' THEN hora END) AS inicio_alimentacion")
    ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA LABORAL TARDE' THEN hora END) AS inicio_labor_tarde")
    ->selectRaw("MAX(CASE WHEN estado = 'FINALIZAR JORNADA LABORAL' THEN hora END) AS fin_jornada")
    ->groupBy('id_user',"fecha")
    ->having('fecha' ,">", $fechaFin)
    ->orderByDesc('fecha')
    ->get();
   // ->toSql();
    }


    public static function verifyStartAssist($fecha,$estado,$cedula){

        return self::where("id_user",$cedula)
        ->where("estado",$estado)
        ->where("fecha", $fecha)
        ->get();


    }

    public static function searchRange($rango){


        return DB::table('historial_asistencia')
        ->select('id_user')
        ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA LABORAL' THEN fecha END) AS fecha")
        ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA LABORAL' THEN hora END) AS inicio_labor")
        ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA ALIMENTARIA' THEN hora END) AS inicio_alimentacion")
        ->selectRaw("MAX(CASE WHEN estado = 'INICIAR JORNADA LABORAL TARDE' THEN hora END) AS inicio_labor_tarde")
        ->selectRaw("MAX(CASE WHEN estado = 'FINALIZAR JORNADA LABORAL' THEN hora END) AS fin_jornada")
        ->groupBy('id_user',"fecha")
        ->having('fecha' , $rango )
        ->orderByDesc('fecha')
        ->get();
       // ->toSql();
    
    }



}
