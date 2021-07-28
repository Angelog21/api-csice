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

        $requestsByResponse = ServiceRequest::where('status','Creado')->with("service","user")->get();
        
        foreach ($requestsByResponse as $value) {
            $value->serviceName = $value->service->name;
            $value->userName = $value->user->name;
            
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

    public function manageRequest(){
        $user = auth()->user();

        $requestsByResponse = ServiceRequest::where('status','Aprobado')->with("service","user")->get();
        
        foreach ($requestsByResponse as $value) {
            $value->serviceName = $value->service->name;
            $value->userName = $value->user->name;
            
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


    public function saveResponse($action,$id){
        try {
            $user = auth()->user();

            $requestById = ServiceRequest::find($id);

            if($requestById->count() == 0){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró la solicitud.",
                    "data" => []
                ],404);
            }

            if($action == "aprobar"){
                $status = "Aprobado";
            }else{
                $status = "Rechazado";
            }

            $requestById->status = $status;
            $requestById->responsed_at = new \DateTime();
            $requestById->save();
    
            return response([
                "success"=>true,
                "message"=>"Se ha cambiado el estado de la solicitud correctamente.",
                "data" => $requestById,
            ],200);
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ha ocurrido un error al intentar cambiar el estado de la solicitud.",
                "data" => $e,
            ],500);
        }
    }
}
