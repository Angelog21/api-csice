<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            'expiration_date'=>$request->expirationDate,
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

        $myRequests = ServiceRequest::where('user_id',$user->id)->with("service",'files')->get();

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

        $requestsByResponse = ServiceRequest::where('status','Aprobado')
        ->with("service","user","user.files","files")->get();
        
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
            $requestById = ServiceRequest::where('id',$id)->with('user','service')->first();


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

            $data = [
                'requestService' => $requestById 
            ];

            Mail::send('emails.response_request', $data, function($message) use ($data,$status) {
                $message->to($data['requestService']->user->email, $data['requestService']->user->email);
                if($status == 'Aprobado'){
                    $message->subject('Tu solicitud ha sido aprobada');
        
                    $pdf = \PDF::loadView('reports.serviceRequest', $data);
                    $message->attachData($pdf->output(), "Solicitud-{$data['requestService']->id}.pdf");
                }else{
                    $message->subject('Tu solicitud ha sido rechazada');
                }
            });
    
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

    public function saveDates($id,Request $request){
        try {
            $requestById = ServiceRequest::where('id',$id)->with('user','service')->first();


            if(!$requestById){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró la solicitud.",
                    "data" => []
                ],404);
            }

            $requestById->start_date = new DateTime($request->start_date);
            $requestById->end_date = new DateTime($request->end_date);
            $requestById->save();
    
            return response([
                "success"=>true,
                "message"=>"Se ha actualizado las fechas de gestión de la solicitud correctamente.",
                "data" => $requestById,
            ],200);
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ha ocurrido un error al intentar cambiar las fechas de la solicitud.",
                "data" => $e,
            ],500);
        }
    }

    public function downloadRequestService($id)
    {
        try {
            $requestService = ServiceRequest::where('id', $id)->with('service','user')->first();
            
            if(!$requestService){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró el registro.",
                    "data" => [],
                ],404);
            }

            if($requestService->user_id != Auth::user()->id){
                if(Auth::user()->role_id == 4){
                    return response([
                        "success"=>false,
                        "message"=>"No tiene permiso para descargar este PDF.",
                        "data" => [],
                    ],403);
                }
            }

            $data = [
                'requestService' => $requestService 
            ];

            $pdf = \PDF::loadView('reports.serviceRequest', $data);
    
            return $pdf->download("Solicitud-{$requestService->id}.pdf");

        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ha ocurrido un error al intentar descargar el reporte de la solicitud.",
                "data" => $e,
            ],500);
        }
    }

    public function sendReminder($id){
        $user = User::find($id);

        if(!$user){
            return response([
                "success"=>false,
                "message"=>"No se encontró el usuario.",
                "data" => [],
            ],404);
        }
        $data = [
            "user" => $user
        ];
        Mail::send('emails.collection_reminder', $data, function($message) use ($user) {
            $message->to($user["email"], $user["email"]);
            $message->subject('Recordatorio de recaudos');
        });

        return response([
            "success"=>true,
            "message"=>"Se ha enviado el recordatorio correctamente.",
            "data" => [],
        ],200);
    }
}
