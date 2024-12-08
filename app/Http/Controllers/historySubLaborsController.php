<?php

namespace App\Http\Controllers;

use App\Models\historial_labores;
use App\Models\modelSubLabores;
use App\Models\modelUser;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;

class historySubLaborsController extends Controller
{



    protected $unrealized = "NO REALIZADO";
    protected $pending = "PENDIENTE";


    public function searchText(Request $request){

        $range = $request->range;
        $text = $request->text;

        
        $range_array = explode(" - ",$range);

        $range_min = Carbon::parse($range_array[0])->format('Y-m-d');

        $range_max = Carbon::parse($range_array[1])->format('Y-m-d');
        

        $serach = historial_labores::searcherForText($range_min,$range_max,$text);
        

        if ($serach) {

            $data =  self::transformHistory($serach);


            $labors = modelSubLabores::getSubLabores();

            $render = view("menuDashboard.historySubLabors", ["historial" => $data, "labores" => $labors])->render();

            return response()->json(["status" => true, "html" => $render]);
        }


    }



    public function searchForRange(Request $request){


        $range = $request->range;

        $range_array = explode(" - ",$range);

        $range_min = Carbon::parse($range_array[0])->format('Y-m-d');

        $range_max = Carbon::parse($range_array[1])->format('Y-m-d');

        $searcherForDate = historial_labores::searchforDate($range_min,$range_max);


        if ($searcherForDate) {

            $data =  self::transformHistory($searcherForDate);

            $labors = modelSubLabores::getSubLabores();

            
            $render = view("menuDashboard.historySubLabors", ["historial" => $data, "labores" => $labors])->render();


            return response()->json(["status" => true, "html" => $render]);
        }


    }


    public function getShowHistorySubLabors(Request $request)
    {


        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);


        $decode_token = JWTAuth::setToken($replace)->authenticate();


        $get_history = historial_labores::showHistory();

        if ($get_history) {

            $data =  self::transformHistory($get_history);

            $labors = modelSubLabores::getSubLabores();

            $render = view("menuDashboard.historySubLabors", ["historial" => $data, "labores" => $labors])->render();

            return response()->json(["status" => true, "html" => $render]);
        }
    }



    public function transformHistory($history)
    {

        $array_transform = [];

        foreach ($history as $item) {


            if($item->id_user === "N/A"){

                $nombre_user = "N/A";
                $last_name = "N/A";

            }else{

                $nombre_user = modelUser::getUserName($item->id_user)->nombre;
                $last_name = modelUser::getLastName($item->id_user)->apellido;

                

            }


            array_push($array_transform,[

                "nombre_user" => $nombre_user,
                "apellido" => $last_name,
                "sub_labor" => $item->nombre_sub_labor,
                "hora" => $item->hora,
                "fecha" => Carbon::parse($item->fecha)->format('d/m/Y'),
                "estado" =>$item->estado

            ]);

        }

        return $array_transform;
    }



    public function collectSubLabors(){



        $get_pending_task = modelSubLabores::getTaskPending($this->pending);

        $data = [];



        if(count($get_pending_task) > 0 ){

            $change_state = modelSubLabores::changeState($this->pending,$this->unrealized);

            if($change_state){



                
            foreach($get_pending_task as $task){

                array_push($data,[
                    
                    "id_user" => "N/A",
                    "id_labor" => "N/A",
                    "nombre_sub_labor" => $task->nombre_sub_labor,
                    "estado" => $this->unrealized,
                    "fecha" => date('Y-m-d'),
                    "hora" => date('H:i:s'),

                ]);


            }

            $insert_history = historial_labores::insertHistory($data);


            return ($insert_history) ? response()->json(["status" => true]): response()->json(["status" => false]);
            }

        }


    }


}
