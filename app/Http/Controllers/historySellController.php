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
        $render = view("menuDashboard.historySell", ["historial" => $history_sells, "total" => $total_venta])->render();

        return response()->json(["status" => true, "html" => $render]);

    }
}
