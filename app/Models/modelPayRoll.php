<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelPayRoll extends Model
{
    use HasFactory;

    protected $table = "nomina";
    protected $fillable = ["id_nomina", "id_user","nombre", "apellido", "url", "fecha"];


    public static function insertPDF($data){

        return self::insert($data);


    }


    public static function getHistoryPayRoll($id_user){


        return self::where("id_user",$id_user)
        ->orderBy("fecha", "desc")
        ->get();
    }
}
