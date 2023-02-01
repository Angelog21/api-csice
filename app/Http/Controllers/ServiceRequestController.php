<?php

namespace App\Http\Controllers;

use App\Models\PivotServiceRequest;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Traits\CustomEncript;
use App\Traits\GenerateCorrelative;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class ServiceRequestController extends Controller
{

    use CustomEncript,GenerateCorrelative;

    public function store(Request $request){
        try {
            if(!isset($request->services) || !isset($request->quantity) || !isset($request->price)){
                return response([
                    "success"=>false,
                    "message" => "Faltan datos para insertar."
                ],200);
            }

            foreach ($request->services as $service) {

                $servicesId[] = $service["service"];
            }

            $findService = ServiceRequest::whereHas('services',function ($q) use ($servicesId) {
                $q->whereIn('service_id',$servicesId);
            })
            ->where('user_id',Auth::user()->id)
            ->where('status', '!=', 'Completado')->get();

            if($findService->where('status','!=','Rechazado')->count() > 0){
                return response([
                    "success"=>false,
                    "message" => "Ya tiene una solicitud con este servicio en proceso."
                ],200);
            }

            $lastRequest = DB::table('service_requests')->orderBy('created_at', 'desc')->limit(1)->get();

            if (count($lastRequest) > 0) {
                $generateCorrelative = $this->generate($lastRequest[0]->correlativo);
            }else{
                $generateCorrelative = $this->generate(null);
            }

            //se inicializa la transaccion
            DB::beginTransaction();
            try {

                $serviceRequest = ServiceRequest::create([
                    'user_id'=>Auth::user()->id,
                    'service_id'=>$servicesId[0]["id"],
                    'quantity'=>$request->quantity,
                    'price'=>$request->price,
                    'correlativo'=>$generateCorrelative,
                    'iva'=>$request->iva,
                    'total'=>$request->total,
                    'expiration_date'=>$request->expirationDate,
                    'status'=>"Creado",
                    'emailList'=>json_encode($request->emails),
                    'created_at'=>Carbon::now()
                ]);

                foreach ($request->services as $service) {
                    PivotServiceRequest::create([
                        'service_id'=>$service["service"]["id"],
                        'service_request_id'=>$serviceRequest->id,
                        'quantity'=>$service["quantity"],
                        'subtotal'=>$service["subtotal"],
                        'iva'=>$service["iva"],
                        'total'=>$service["total"],
                        'iva_value'=>$service["iva_value"],
                        'petro_quantity'=>$service["petro_quantity"],
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return response([
                    "success"=>false,
                    "message" => "Ha ocurrido un error en el servidor con la transaccion.",
                    "error" => $e->getMessage()
                ],500);
            }

            Mail::send('emails.response_request', ["requestService" => $serviceRequest], function($message) use ($serviceRequest) {
                $message->to($serviceRequest->user->email, $serviceRequest->user->email);
                $message->subject('Tu solicitud se ha creado correctamente');
            });

            if(!empty($request->emails)){
                //encriptar el id del servicio para la url
                $serviceRequest["encript_id"] = $serviceRequest["id"];
                try {
                    //recorre cada email que se agrega desde el front
                    foreach($request->emails as $email){
                        //enviara el correo con el enlace al formulario
                        Mail::send('emails.service_register', ["serviceRequest"=>$serviceRequest], function($message) use ($email) {
                            $message->to($email, $email);
                            $message->subject('Registro de datos del signatario');
                        });
                    }
                } catch (\Exception $e) {

                    return response([
                        "success"=>false,
                        "message" => "Ha ocurrido un error en el servidor al enviar correo.",
                    ],500);
                }
            }

            return response([
                "success"=>true,
                "message" => "Se ha guardado correctamente la solicitud del servicio.",
                "serviceRequest" => $serviceRequest
            ],200);
        } catch (\Exception $e) {
            Log::info($e);
            return response([
                "success"=>false,
                "message" => "Ha ocurrido un error en el servidor.",
                "error" => $e
            ],500);
        }
    }

    public function myRequests(){
        $user = auth()->user();

        $myRequests = ServiceRequest::where('user_id',$user->id)->with("service","services",'files')->get();

        foreach ($myRequests as $value) {
            $value->serviceName = $value->service->name;
        }

        return response([
            "success"=>true,
            "data" => $myRequests
        ],200);
    }

    public function requestByReview(){
        $user = auth()->user();

        $requestsByResponse = ServiceRequest::where('status','Creado')->with("service","services","user")->get();

        foreach ($requestsByResponse as $value) {
            $value->serviceName = $value->service->name;
            $value->userName = $value->user->name;
        }

        return response([
            "success"=>true,
            "data" => $requestsByResponse
        ],200);
    }

    public function requestByResponse(){
        $user = auth()->user();

        $requestsByResponse = ServiceRequest::where('status','Revisado')->with("service","services","user")->get();

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

    public function allRequests(){

        $allRequests = ServiceRequest::with("service","services","user")->get();

        return response([
            "success"=>true,
            "data" => $allRequests
        ],200);
    }

    public function manageRequest(){
        $user = auth()->user();

        $requestsByResponse = ServiceRequest::where('status','Aprobado')
        ->with("services","user","files")->get();

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
            $requestById = ServiceRequest::where('id',$id)->with('user','service',"services")->first();


            if($requestById->count() == 0){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró la solicitud.",
                    "data" => []
                ],404);
            }

            if($action == "aprobar"){
                $status = "Aprobado";
            } elseif ($action == "rechazar"){
                $status = "Rechazado";
            } elseif ($action == "revisar") {
                $status = "Revisado";
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
                    $message->attachData($pdf->output(), "{$data['requestService']->correlativo}.pdf");
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
                "data" => $e->getMessage(),
            ],500);
        }
    }

    public function updateCorrelative(Request $request){
        try {
            $requestById = ServiceRequest::where('id',$request['id'])->with('user','service',"services")->first();

            if($requestById->count() == 0){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró la solicitud.",
                    "data" => []
                ],404);
            }

            $requestById->correlativo = $request['correlativo'];
            $requestById->save();

            return response([
                "success"=>true,
                "message"=>"Se ha cambiado el estado de la solicitud correctamente.",
                "data" => $requestById,
            ],200);
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ha ocurrido un error al intentar cambiar el correlativo de la solicitud.",
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

    public function saveHour($id,Request $request){
        try {
            $requestById = ServiceRequest::where('id',$id)->with('user','service')->first();


            if(!$requestById){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró la solicitud.",
                    "data" => []
                ],404);
            }

            $requestById->start_time = new DateTime($request->start_time);
            $requestById->save();

            return response([
                "success"=>true,
                "message"=>"Se ha actualizado la hora de gestión de la solicitud correctamente.",
                "data" => $requestById,
            ],200);
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ha ocurrido un error al intentar cambiar la hora de la solicitud.",
                "data" => $e,
            ],500);
        }
    }

    public function saveClientDate($id,Request $request){
        try {
            $requestById = ServiceRequest::where('id',$id)->first();


            if(!$requestById){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró la solicitud.",
                    "data" => []
                ],404);
            }

            $requestById->start_date = new DateTime($request->selectedDate);
            $requestById->end_date = new DateTime($request->selectedDate);
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
            $requestService = ServiceRequest::where('id', $id)->with('service',"services",'user')->first();

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

            return response([
                "success"=>true,
                "data" => 'data:application/pdf;base64,'.base64_encode($pdf->stream())
            ],200);

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

    public function requestFinish($id,Request $request){
        try {
            $requestById = ServiceRequest::where('id',$id)->with('user','service')->first();


            if(!$requestById){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró la solicitud.",
                    "data" => []
                ],404);
            }

            $requestById->status = 'Completado';
            $requestById->observation = $request->observation;
            $requestById->completed_at = new \DateTime();
            $requestById->save();

            $data = [
                'requestService' => $requestById
            ];

            Mail::send('emails.request_ending', $data, function($message) use ($data) {
                $message->to($data['requestService']->user->email, $data['requestService']->user->email);
                $message->subject('Tu solicitud de servicio se ha completado exitosamente');
            });

            return response([
                "success"=>true,
                "message"=>"Se ha finalizado el proceso de la solicitud correctamente.",
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

    public function scriptNewStructure () {
        try {
            $allRequests = ServiceRequest::doesntHave('services')->with('service')->get();

            foreach ($allRequests as $serviceRequest) {

                PivotServiceRequest::create([
                    'service_id'=>$serviceRequest->service->id,
                    'service_request_id'=>$serviceRequest->id,
                    'quantity'=>$serviceRequest->quantity,
                    'subtotal'=>$serviceRequest->price,
                    'iva'=>$serviceRequest->iva,
                    'total'=>$serviceRequest->total,
                    'iva_value'=>$serviceRequest->service->iva_value,
                    'petro_quantity'=>$serviceRequest->service->petro_quantity,
                ]);
            }

            return response([
                "success"=>true,
                "message"=>"Recuperados",
                "data" => $allRequests
            ],200);
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ha ocurrido un error en el servidor",
                "data" => $e->getMessage()
            ],500);
        }
    }

    public function getRequestsByStatus ($status) {
        try {

            $requestsByStatus = ServiceRequest::where('status',$status)->with("services","user")->get();

            return response([
                "success"=>true,
                "data" => $requestsByStatus
            ],200);

        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>'Ha ocurrido un error en el servidor',
                "data" => $e
            ],200);
        }
    }

}
