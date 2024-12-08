<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelUser;
use App\Models\modelShedule;
use App\Models\modelScheduleClear;
use Tymon\JWTAuth\Facades\JWTAuth;


class scheduleController extends Controller
{


    public function getShowSchedule(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $rol= $decode_token["rol"];

        $view = modelShedule::getShowSchedule();


        $render = view("menuDashboard.schedules", ["users" => $view, "rol" => $rol])->render();

        return response()->json(["status" => true, "html" => $render]);
    }

    public function insertSchedule(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $rol= $decode_token["rol"];

        $option = $request->option;
        $id_user =  $request->id_user;
        $schedule = $request->total_time;
        $dia = $request->dia;


        if ($option == 1) {


            $edit = modelShedule::insertSchedule($id_user, $dia, $schedule);

            if ($edit) {

                $view = modelShedule::getShowSchedule();

                $render = view("menuDashboard.schedules", ["users" => $view, "rol" => $rol])->render();

                return response()->json(["status" => true, "html" => $render]);
            }
        } else if ($option == 2) {

            $data = ["lunes" => $schedule, "martes" => $schedule, "miercoles" => $schedule, "jueves" => $schedule, "viernes" => $schedule];

            
            $insert_LV = modelShedule::insertLV($id_user, $data);
            

            if ($insert_LV) {

                $view = modelShedule::getShowSchedule();

                $render = view("menuDashboard.schedules", ["users" => $view, "rol" => $rol])->render();

                return response()->json(["status" => true, "html" => $render]);
            }
        }

        return response()->json(["status" => false]);
    }


    public function scheduleclear(Request $request){


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $rol= $decode_token["rol"];

        $id_user = $request->id_user;
        $dia = $request->dia;

        $aseo = "aseo-" .$dia;

        $data = modelScheduleClear::insertScheduleClear($id_user, $aseo);

        if($data){

        $view = modelShedule::getShowSchedule();

        $render = view("menuDashboard.schedules", ["users" => $view, "rol" => $rol])->render();

        return response()->json(["status" => true, "html" => $render]);

        }


        return response()->json(["status" => false]);


    }


    public function deleteClear(Request $request){

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $rol= $decode_token["rol"];


        $cedula = $request->cedula;
        $dia = $request->dia;
        $delete = modelScheduleClear::editClear($cedula, $dia); // eliminar ese item 
        

        if($delete){

            $view = modelShedule::getShowSchedule();


            $render = view("menuDashboard.schedules", ["users" => $view, "rol" => $rol])->render();
    
            return response()->json(["status" => true, "html" => $render]);


        }

        return response()->json(["status" => false]);

    }



}
