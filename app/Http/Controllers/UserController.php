<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers(){
        try {
            $me = auth()->user();
            $users = User::where('role_id',4)->get();

            if($users->count() == 0){
                return response([
                    "success"=>false,
                    "message"=>"No se encontraron usuarios.",
                    "data" => []
                ],200);
            }

            foreach($users as $user){
                if($me->role_id == 3){
                    $user->action = true;
                }
            }

            return response([
                "success"=>true,
                "message"=>"Lista de usuarios.",
                "data" => $users
            ],200);

        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ocurrió un error en el servidor.",
                "data" => $e
            ],500);
        }
    }

    public function setStatusUser($status,$id){
        try {
            $user = User::find($id);

            if(empty($user)){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró el usuario.",
                    "data" => []
                ],200);
            }


            if($status == "activar"){
                $sta = true;
            }else{
                $sta = false;
            }

            $user->active = $sta;
            $user->save();

            return response([
                "success"=>true,
                "message"=>"Usuario actualizado correctamente.",
                "data" => $user
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
