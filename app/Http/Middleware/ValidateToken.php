<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Print_;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //$token = $request->header("Authorization"); // Esto obtiene el token de la cabecera

        // try {
        //     // Intentar obtener el usuario autenticado usando el token
        //     if (!$user = JWTAuth::parseToken()->authenticate()) {
        //         return response()->json(['error' => 'Usuario no encontrado'], 404);
        //     }
        // } catch (JWTException $e) {
        //     // No se pudo crear el token
        //     return response()->json(['error' => 'Token inválido'], 401);
        // }

        $token = $request->query("token");


        $decode_token = JWTAuth::setToken($token)->authenticate();

        if($decode_token){



            return $next($request);
        }

        else{


            return response()->json(["access_denied" => "token no válido o vencido!"]);
        }

    }

}