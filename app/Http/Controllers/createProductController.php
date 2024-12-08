<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class createProductController extends Controller
{
    public function createProducts(Request $request){


        $render = view("menuDashboard.createProduct")->render();

        return response()->json([ "status" => true, "html" => $render]);


    }
}
