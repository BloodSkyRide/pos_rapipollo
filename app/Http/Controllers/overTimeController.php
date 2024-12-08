<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelUser;
use App\Models\modelOverTime;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Events\RealtimeEvent;
use App\Events\ResponseAdmin;


class overTimeController extends Controller
{

    protected $pending = "Pendiente";

    protected $accepted = "Aceptado";

    protected $rejected= "Rechazado";

    public function sendOverTime(Request $request){


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $name = modelUser::getName($self_id)->nombre;

        $last_name = modelUser::getLastName($self_id)->apellido;

        $today = Carbon::now()->format('y-m-d');

        $time = Carbon::now();


        $motivo = $request->motivo;
        $fecha = $request->fecha;
        $hora_i = $request->hora_i;
        $hora_f = $request->hora_f;
        
        $data = ["id_user" => $self_id, "nombre" => $name, "apellido" => $last_name, "fecha_solicitud" => $today, "hora_solicitud" =>  $time, "hora_inicio" => $hora_i,
    "hora_final" => $hora_f, "fecha_notificacion" => $fecha, "motivo" => $motivo, "estado" => $this->pending];

        $insert = modelOverTime::insertNotification($data);

        if($insert){

            self::sendnotification($name, $last_name, $fecha);

           return  response()->json(["status" =>true]);

        }

        return response()->json(["status" => false]);

    }


    public function sendnotification($name, $lastName, $fecha){


        $message = "El usuario $name $lastName solicitó realizar horas extra en la fecha: $fecha! ¡Revisa tu pestaña de notificaciones!";

        broadcast(new RealtimeEvent($message))->toOthers();
        
    }

    public function getShowOverTimeAdmin(Request $request){

        $notifications = modelOverTime::getAllNotifications();

        $render = view("menuDashboard.historyOverTime",["notifications" => $notifications])->render();


        return response()->json(["status" => true, "html" => $render]);
    }

    public function changeStateOverTime(Request $request){


        $state = $request->state;
        $id_notification = $request->id_notification;

        $state_final = ($state === "Aceptar") ? $this->accepted : $this->rejected;

        $change = modelOverTime::changeState($state_final, $id_notification);

        if($change){
            
            $notifications = modelOverTime::getAllNotifications();

            $message = "Tu solicitud de horas extras fué $state_final!";
            $id_user = modelOverTime::getId_user($id_notification)->id_user;

            broadcast(new ResponseAdmin($message, $id_user,$state_final));

            $render = view("menuDashboard.historyOverTime",["notifications" => $notifications])->render();
            
            return response()->json(["state" => true, "html" => $render]);

        }

        return response()->json(["state" => false]);

    }
}
