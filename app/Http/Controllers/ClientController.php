<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientFile;
use App\Traits\CustomEncript;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    use CustomEncript;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($serviceRequestId)
    {
        try {
            if (!$serviceRequestId) {
                return response([
                    "success"=>false,
                    "message" => "Falta el id de la solicitud.",
                ],400);
            }

            $data = Client::where('service_request_id',$serviceRequestId)->get();

            return response([
                "success"=>true,
                "data" => $data,
            ],200);
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message" => "Ha ocurrido un error en el servidor.",
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (isset($request->serviceRequestId)) {
                $serviceRequestId = $request->serviceRequestId;

                $client = Client::select('identification_card')
                    ->where('identification_card', $request->identificationCard)
                    ->first();

                if ($client) {
                    return response([
                        "success" => false,
                        "message" => "El documento de identidad ya existe!",
                    ],200);
                }

                $client = Client::create([
                    "service_request_id"=>$serviceRequestId,
                    "document_type" => $request->documentType,
                    "identification_card" => $request->identificationCard,
                    "email" => $request->email,
                    "names" => $request->names,
                    "surnames" => $request->surnames,
                    "state" => $request->state,
                    "municipality" => $request->municipality,
                    "direction" => $request->direction,
                    "institution_name" => $request->institutionName ? $request->institutionName : $request->names,
                    "organizational_unit" => $request->organizationalUnit ? $request->organizationalUnit : '',
                    "phone" => $request->phone,
                    "office_phone" => $request->officePhone ? $request->officePhone : ''
                ]);

                return response([
                    "success"=>true,
                    "data"=>$client,
                    "message" => "Se ha creado el signatario correctamente.",
                ],200);
            }else{
                return response([
                    "success"=>false,
                    "message" => "Falta el id de la solicitud.",
                ],400);
            }
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message" => "Ha ocurrido un error en el servidor.",
                "data" => $e
            ],500);
        }
    }

    public function saveFiles(Request $request){
        try {
            $client = Client::find($request->get('client_id'));

            if (!$client) {
                return response([
                    "success"=>false,
                    "message"=>"No se encontró el client.",
                    "data" => []
                ],404);
            }

            $personalFiles = ClientFile::where('client_id',$client->id)->get();

            if ($request->file('cedula')) {
                if ($personalFiles->where('type','cedula')->count() == 0 || 
                    $personalFiles->where('type','Cédula')->count() == 0) {

                    $cedula = $request->file('cedula');
                    $nombreCedula = $cedula->getClientOriginalName();
                    Storage::disk('local')->put("public/clients/{$client->id}/{$nombreCedula}",  File::get($cedula));
                    clientFile::create([
                        'client_id'=>$client->id,
                        'type'=>'Cédula',
                        'name'=>$nombreCedula,
                        'url'=>"public/clients/{$client->id}/{$nombreCedula}"
                    ]);
                }
            }

            if($request->file('rif')){
                if ($personalFiles->where('type','RIF')->count() == 0 || $personalFiles->where('type','rif')->count() == 0) {
                    $rif = $request->file('rif');
                    $nombreRif = $rif->getClientOriginalName();
                    Storage::disk('local')->put("public/clients/{$client->id}/{$nombreRif}",  File::get($rif));
                    clientFile::create([
                        'client_id'=>$client->id,
                        'type'=>'RIF',
                        'name'=>$nombreRif,
                        'url'=>"public/clients/{$client->id}/{$nombreRif}"
                    ]);
                }
            }

            if($request->file('nombramiento')){
                if ($personalFiles->where('type','nombramiento')->count() == 0 || $personalFiles->where('type','Nombramiento')->count() == 0) {
                    $nombramiento = $request->file('nombramiento');
                    $nombreNombramiento = $nombramiento->getClientOriginalName();
                    Storage::disk('local')->put("public/clients/{$client->id}/{$nombreNombramiento}",  File::get($nombramiento));
                    ClientFile::create([
                        'client_id'=>$client->id,
                        'type'=>'Nombramiento',
                        'name'=>$nombreNombramiento,
                        'url'=>"public/clients/{$client->id}/{$nombreNombramiento}"
                    ]);
                }
            }
            
            return response([
                "success"=>true,
                "message"=>"Se ha guardado correctamente.",
                "data" => []
            ],200);

        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ocurrió un error en el servidor.",
                "data" => $e->getMessage()
            ],500);
        }
    }


    public function getFiles($clientId)
    {
        try {
            if (!$clientId) {
                return response([
                    "success"=>false,
                    "message" => "Falta el id de la solicitud.",
                ],400);
            }

            $data = ClientFile::where('client_id',$clientId)->get();

            return response([
                "success"=>true,
                "data" => $data,
            ],200);
        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message" => "Ha ocurrido un error en el servidor.",
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
