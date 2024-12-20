<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelSell;
use Carbon\Carbon;

class historySellController extends Controller
{
    public function getShowHistorySell(Request $request){

        $today = Carbon::now()->format('Y-m-d');

        
        $history_sells = modelSell::getSells($today);
        
        $total_venta = modelSell::totalSells($today);

        $total_venta_unificada = modelSell::unitTotalSells($today);


        $render = view("menuDashboard.historySell", ["historial" => $history_sells, "total" => $total_venta, "unificado" => $total_venta_unificada])->render();

        return response()->json(["status" => true, "html" => $render]);

    }


    public function searchForRangeHistory(Request $request){


        $today = $request->fecha;

        $history_sells = modelSell::getSells($today);
        
        $total_venta = modelSell::totalSells($today);

        $total_venta_unificada = modelSell::unitTotalSells($today);


        $render = view("menuDashboard.historySell", ["historial" => $history_sells, "total" => $total_venta, "unificado" => $total_venta_unificada])->render();

        return response()->json(["status" => true, "html" => $render]);

    }
}
