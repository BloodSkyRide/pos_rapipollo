<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Payload;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use App\Models\modelUser; 

class tokenController extends Controller
{
    public function token(Request $request){

        $cedula = $request->input('cedula');
        $password = $request->input('pass');

        $token = modelUser::getuserAndPassword($cedula);
        $pass_bd = $token->password;
        $validator = Hash::check($password, $pass_bd);

        if ($validator) { // clase para validar las claves hash traidas desde el model

            $payload = [
                
                "nombre" => $token->nombre,
                "cedula" => $token->cedula,
                "apellido" => $token->apellido,
                "rol" => $token->rol,
                "email" => $token->email,
                "telefono" => $token->telefono,
                "password" => $password
            ];

            
            
            $create_token = JWTAuth::attempt($payload);
            // $user = auth()->user();

            return response()->json(["access_token" => $create_token, "status" => true]);

        } else {

            print("clave erronea");
        }

        return response()->json(["status" => $cedula]);
    }


    public function validateToken(Request $request){

        $token = $request->query("token");
        
        




    }
}
