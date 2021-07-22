<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsNotClient
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
        if($request->user()->role_id == 4){
            return response([
                "success"=>false,
                "message"=>"No tienes los permisos necesarios para ejecutar esta acción",
                "data" => []
            ],403);
        }
        return $next($request);
    }
}
