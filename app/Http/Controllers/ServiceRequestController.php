<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function store(Request $request){
        if(!isset($request->service_id) || !isset($request->quantity) || !isset($request->price)){
            return response([
                "success"=>false,
                "message" => "Faltan datos para insertar."
            ],200);
        }

        $findService = ServiceRequest::where('service_id',$request->service_id)->where('user_id',Auth::user()->id)->where(function ($query){
            $query->where('status', '!=', 'Completado')
            ->orWhere('status', '!=', 'Rechazado');
        })->get();

        if($findService->count() > 0){
            return response([
                "success"=>false,
                "message" => "Ya tiene una solicitud con este servicio en proceso."
            ],200);
        }

        $serviceRequest = ServiceRequest::create([
            'user_id'=>Auth::user()->id,
            'service_id'=>$request->service_id,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'iva'=>$request->iva,
            'total'=>$request->total,
            'status'=>"Creado",
            'created_at'=>Carbon::now()
        ]);

        return response([
            "success"=>true,
            "message" => "Se ha guardado correctamente la solicitud del servicio.",
            "serviceRequest" => $serviceRequest
        ],200);
    }

    public function myRequests(){
        $user = auth()->user();

        $myRequests = ServiceRequest::where('user_id',$user->id)->with("service")->get();

        foreach ($myRequests as $value) {
            $value->serviceName = $value->service->name; 
        }

        return response([
            "success"=>true,
            "data" => $myRequests
        ],200);
    }

    public function requestByResponse(){
        $user = auth()->user();

        $requestsByResponse = ServiceRequest::where('status','Creado')->with("service")->get();
        
        foreach ($requestsByResponse as $value) {
            $value->serviceName = $value->service->name;
            if($value->quantity > 10 && $user->role_id == 1){
                $value->actions = true;
            }elseif($value->quantity <= 10 && $user->role_id == 2){
                $value->actions = true;
            }else{
                $value->actions = false;
            }
        }

        return response([
            "success"=>true,
            "data" => $requestsByResponse
        ],200);
    }
}
