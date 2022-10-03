<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();

        foreach($services as $service){
            $service->iva_value = $service->iva_value*100;
        }

        return $services->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isset($request->name) || !isset($request->code) || !isset($request->petro_quantity) || !isset($request->service_to)){
            return response([
                "success"=>false,
                "message" => "Faltan datos para insertar."
            ],200);
        }

        $findService = Service::where('code',$request->code)->orWhere('name',$request->name)->get();

        if($findService->count() > 0){
            return response([
                "success"=>false,
                "message" => "Ya existe el servicio."
            ],200);
        }

        $service = Service::create([
            'name'=>$request->name,
            'unit'=>$request->unit,
            'code'=>$request->code,
            'petro_quantity'=>$request->petro_quantity,
            'service_to'=>$request->service_to,
            'iva_value'=>$request->iva_value
        ]);

        return response([
            "success"=>true,
            "message" => "Se ha guardado correctamente el servicio.",
            "service" => $service
        ],200);
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
        if(!isset($request->name) || !isset($request->code) || !isset($request->petro_quantity)){
            return response([
                "success"=>false,
                "message" => "Faltan datos para insertar."
            ],200);
        }

        $findService = Service::where('code',$request->code)->orWhere('name',$request->name)->get();

        if($findService->where('id','!=',$id)->count() > 0){
            return response([
                "success"=>false,
                "message" => "Ya existe el servicio."
            ],200);
        }

        $service = Service::where('id',$id)->first();

        $service->update([
            'name'=>$request->name,
            'code'=>$request->code,
            'petro_quantity'=>$request->petro_quantity,
            'iva_value'=>$request->iva_value/100
        ]);

        $service->save();

        return response([
            "success"=>true,
            "message" => "Se ha guardado correctamente el servicio.",
            "service" => $service
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!isset($id)){
            return response(["success"=>false,"message"=>"Falta el id del servicio."]);
        }

        Service::destroy($id);

        return response(["success"=>true,"message"=>"Eliminado correctamente."]);
    }
}
