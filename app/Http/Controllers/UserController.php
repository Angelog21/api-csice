<?php

namespace App\Http\Controllers;

use App\Models\PaymentFile;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function getUsers(){
        try {
            $me = auth()->user();
            $users = User::get();

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

    public function setRoleUser(Request $request){
        try {
            if (!isset($request->id)) {
                return response([
                    "success"=>false,
                    "message"=>"Debe enviar el id del usuario.",
                    "data" => []
                ],200);
            }

            $user = User::find($request->id);

            if(empty($user)){
                return response([
                    "success"=>false,
                    "message"=>"No se encontró el usuario.",
                    "data" => []
                ],200);
            }

            $user->role_id = $request->role_id;
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

    public function saveFiles(Request $request){
        try {
            $user = User::find($request->get('user_id'));

            if (!$user) {
                return response([
                    "success"=>false,
                    "message"=>"No se encontró el user.",
                    "data" => []
                ],404);
            }

            $personalFiles = UserFile::where('user_id',$user->id)->get();

            if ($request->file('cedula')) {
                if ($personalFiles->where('type','cedula')->count() == 0 || $personalFiles->where('type','Cédula')->count() == 0) {
                    $cedula = $request->file('cedula');
                    $nombreCedula = $cedula->getClientOriginalName();
                    Storage::disk('local')->put("public/{$user->id}/{$nombreCedula}",  File::get($cedula));
                    UserFile::create([
                        'user_id'=>$user->id,
                        'type'=>'Cédula',
                        'name'=>$nombreCedula,
                        'url'=>"public/{$user->id}/{$nombreCedula}"
                    ]);
                }
            }

            if($request->file('rif')){
                if ($personalFiles->where('type','RIF')->count() == 0 || $personalFiles->where('type','rif')->count() == 0) {
                    $rif = $request->file('rif');
                    $nombreRif = $rif->getClientOriginalName();
                    Storage::disk('local')->put("public/{$user->id}/{$nombreRif}",  File::get($rif));
                    UserFile::create([
                        'user_id'=>$user->id,
                        'type'=>'RIF',
                        'name'=>$nombreRif,
                        'url'=>"public/{$user->id}/{$nombreRif}"
                    ]);
                }
            }

            if($request->file('nombramiento')){
                if ($personalFiles->where('type','nombramiento')->count() == 0 || $personalFiles->where('type','Nombramiento')->count() == 0) {
                    $nombramiento = $request->file('nombramiento');
                    $nombreNombramiento = $nombramiento->getClientOriginalName();
                    Storage::disk('local')->put("public/{$user->id}/{$nombreNombramiento}",  File::get($nombramiento));
                    UserFile::create([
                        'user_id'=>$user->id,
                        'type'=>'Nombramiento',
                        'name'=>$nombreNombramiento,
                        'url'=>"public/{$user->id}/{$nombreNombramiento}"
                    ]);
                }
            }

            if($request->file('paymentFile')){
                $comprobante = $request->file('paymentFile');
                $nombreComprobante = $comprobante->getClientOriginalName();
                Storage::disk('local')->put("public/{$user->id}/comprobante-pagos/{$nombreComprobante}",  File::get($comprobante));
                PaymentFile::create([
                    'user_id'=>$user->id,
                    'service_requests_id'=>$request->get('service_request_id'),
                    'name'=>$nombreComprobante,
                    'url'=>"public/{$user->id}/comprobante-pagos/{$nombreComprobante}"
                ]);
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

    public function getFiles($id = null){
        try {
            $user = Auth::user();

            if(isset($id) && $user->role_id != 4){
                $user = User::find($id);
            }

            $files = UserFile::where('user_id',$user->id)->get();

            return response([
                "success"=>true,
                "message"=>"Positivo",
                "data" => $files
            ],200);


        } catch (\Exception $e) {
            return response([
                "success"=>false,
                "message"=>"Ocurrió un error en el servidor.",
                "data" => $e
            ],500);
        }
    }

    public function downloadFile(Request $request){

        $file = $request->get('url');
        if(Storage::disk('local')->exists($file)){
            $file = base64_encode(Storage::get($file));
            $imgdata = base64_decode($file);

            $f = finfo_open();
            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);

            $file = "data:{$mime_type};base64,".$file;

            return response([
                "success"=>true,
                "message"=>"Positivo",
                "data" => $file
            ],200);
        }
        return response([
            "success"=>false,
            "message"=>"No se encontró el archivo",
            "data" => []
        ],200);
    }

    public function deleteUser ($id = null) {
        try {

            PaymentFile::where('user_id',$id)->delete();
            $servicesRequests = ServiceRequest::where('user_id',$id)->get();
            $servicesRequests->services()->detach();
            $servicesRequests->delete();
            UserFile::where('user_id',$id)->delete();
            User::where('id',$id)->delete();

            return response([
                "success"=>true,
                "message"=>"Usuario Eliminado correctamente.",
                "data" => []
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
