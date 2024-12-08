<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelSubLabores;
use App\Models\labores;
use App\Models\historial_labores;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class subLaborsController extends Controller
{

    protected $state_pending = "PENDIENTE";
    protected $state_realized = "REALIZADO";

    public function deleteSubLabors(Request $request){

        $array = $request->ids_deletes;

        $asocciate = [];

        foreach($array as $item){

            array_push($asocciate,[

                "id_sub_labor" => $item

            ]);

        }

        
        
        $deleted = modelSubLabores::deleteSubLabors($asocciate);
        
       

        if($deleted){

            $labores = labores::getLabores();
        
            $getSubLabores = modelSubLabores::getSubLabores();
    
            $htmlContent = view("menuDashboard.manejoLabores", ["labores" => $labores, "sublabores" => $getSubLabores])->render();
    
            return response()->json(["status" => true, "html" => $htmlContent]);

        }


    }


    public function insertSubLabor(Request $request){


        $array_subLabors = $request->texts;

        $labor_principal = $request->id_labor_principal;

        $array = [];
        foreach($array_subLabors as $sublabors){

            array_push($array,[

                "nombre_sub_labor" => $sublabors,
                "id_labor" => $labor_principal,
                "estado" => $this->state_pending,
                "fecha_creacion" => Carbon::now()
            ]);

        }

        $insert = modelSubLabores::addSubLabors($array);


        if($insert){

        
            $labores = labores::getLabores();
        

            $getSubLabores = modelSubLabores::getSubLabores();
    
            
            $htmlContent = view("menuDashboard.manejoLabores", ["labores" => $labores, "sublabores" => $getSubLabores])->render();
    
    
    
            return response()->json(["status" => true, "html" => $htmlContent]);

        }
        

    }




    public function historySubLabor(Request $request){


        $checked = $request->checked;

        
        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ","",$token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $id_user = $decode_token["cedula"];
        $id_labor = $decode_token["id_labor"];

        $fecha = Carbon::now()->format('y-m-d');
        
        $hora = Carbon::now();


        $inserts = count($checked);
        $confirm = 0;

        
        foreach($checked as $nombre){
            
            $data = ["id_user" => $id_user, "id_labor" => $id_labor, "nombre_sub_labor"=> $nombre, "estado" => $this->state_realized, "fecha" => $fecha, "hora" => $hora];
            $insert = historial_labores::insertHistory($data);

            if($insert){

                $change_state = modelSubLabores::changeStateSubLabor($id_labor,$nombre,$this->state_realized);
                $confirm++;
            }

        }

        if($inserts === $confirm){



            $getGroupLabors = modelSubLabores::getSubLaborsForId($id_labor,$this->state_pending);

            if ($getGroupLabors) {
    
    
                $render = view("menuDashboard.myLabors", ["sublabors" => $getGroupLabors])->render();
    
                return response()->json(["status" => true, "html" => $render]);
            }

        }


        return response()->json(["status" => false, "messagge" => "No se pudó acceder a la base de datos para las sub labores!"]);

        
    }



    public function rechargeSubLabors(Request $request){

        $checked = $request->checked;

        $asocciate = [];

        foreach($checked as $item){

            array_push($asocciate,[

                "id_sub_labor" => $item

            ]);

        }

        $recharge_states = modelSubLabores::rechargeSubLabors($asocciate,$this->state_pending);

        if($recharge_states){


            return response()->json(["status" => true]);
        }


        return response()->json(["status" => false]);

    }
}
