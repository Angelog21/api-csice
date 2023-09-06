<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petro;

class PetroController extends Controller
{
    public function getPetroPrice()
    {
        try {

            $data = Petro::first();

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

    public function updatePetroPrice(Request $request){

        try {

            $petro = Petro::first();

            $petro->price = $request->petroPrice;

            $petro->save();

            return response([
                "success"=>true,
                "message"=>"Precio actualizado correctamente.",
                "data" => $petro
            ],200);

        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ocurrió un error en el servidor.",
                "data" => $e
            ],500);
        }
    }
}
