<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\CustomEncript;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    use CustomEncript;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                $serviceRequestId = $this->decrypt($request->serviceRequestId,"serviceRequestId");

                Client::create([
                    "service_request_id"=>$serviceRequestId,
                    "document_type" => $request->documentType,
                    "identification_card" => $request->identificationCard,
                    "email" => $request->email,
                    "names" => $request->names,
                    "surames" => $request->surames,
                    "state" => $request->state,
                    "municipality" => $request->municipality,
                    "direction" => $request->direction,
                    "institution_name" => $request->institutionName,
                    "organizational_unit" => $request->organizationalUnit,
                    "phone" => $request->phone,
                    "office_phone" => $request->officePhone
                ]);

                return response([
                    "success"=>true,
                    "message" => "Se ha creado el signatario correctamente.",
                ],200);
            }else{
                return response([
                    "success"=>false,
                    "message" => "Falta el id de la solicitud.",
                ],400);
            }
        } catch (\Throwable $th) {
            return response([
                "success"=>false,
                "message" => "Ha ocurrido un error en el servidor.",
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
