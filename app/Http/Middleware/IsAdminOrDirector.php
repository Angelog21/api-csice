<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminOrDirector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Si no es rol admin 1 o director 2
        if($request->user()->role_id != 1 && $request->user()->role_id != 2){
            return response([
                "success"=>false,
                "message"=>"No tienes los permisos necesarios para ejecutar esta acción",
                "data" => []
            ],403);
        }
        return $next($request);
    }
}
