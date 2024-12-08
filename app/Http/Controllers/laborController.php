<?php

namespace App\Http\Controllers;
use App\Models\labores;
use Illuminate\Http\Request;
use App\Models\modelSubLabores;

class laborController extends Controller
{
    public function insertLabor(Request $request){


        $name = $request->name_labor;

        $insert = labores::insertLabor($name);


        if($insert){



            $labores = labores::getLabores();
        

            $getSubLabores = modelSubLabores::getSubLabores();
    
            
            $htmlContent = view("menuDashboard.manejoLabores", ["labores" => $labores, "sublabores" => $getSubLabores])->render();
    
    
    
            return response()->json(["status" => true, "html" => $htmlContent]);
        }


    }


    public function editLabor(Request $request){

        $new_name = $request->nombre_nuevo;
        $id_labor = $request->id_labor;


        $edit = labores::modifyName($id_labor,$new_name);


        if($edit){

            $labores = labores::getLabores();
        

            $getSubLabores = modelSubLabores::getSubLabores();
    
            
            $htmlContent = view("menuDashboard.manejoLabores", ["labores" => $labores, "sublabores" => $getSubLabores])->render();
    
    
    
            return response()->json(["status" => true, "html" => $htmlContent]);


        }


    }
}
