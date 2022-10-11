<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        try {
            $attr = $request->all();

            if(!isset($request->role)){
                $attr["role"] = 4;
            }else{
                $attr["role"] = $request->role;
            }

            if(User::where('email',strtolower($attr["email"]))->exists()){
                return $this->error("El usuario que intenta ingresar ya existe.",200,[]);
            }

            $attr["confirmation_code"] = Str::random(35);

            $user = User::create([
                'name' => $attr['name'],
                'social_reason' => $attr['social_reason'],
                'phone' => $attr['phone'],
                'rif' => $attr['rif'],
                'direction' => $attr['direction'],
                'password' => bcrypt($attr['password']),
                'email' => strtolower($attr['email']),
                'role_id' => $attr["role"],
                'confirmation_code'=>$attr["confirmation_code"],
                'email_verified_at' => $attr['role'] != 4 ? new DateTime() : null
            ]);
            //si el rol no es el de cliente, no hace falta la verificación
            if($attr['role'] == 4){
                Mail::send('emails.confirmation_code', $attr, function($message) use ($attr) {
                    $message->to(strtolower($attr['email']), $attr['name'])->subject('Por favor confirma tu correo');
                });
            }

            return $this->success(["user"=>$user],"Usuario registrado correctamente debe verificar.");
        } catch (\Exception $e) {
            return $this->error("Ha ocurrido un error en el servidor",500,$e);
        }
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!isset($credentials["email"])){
            return response()->json([
                "error"=>true,
                "message"=>"Debe ingresar un correo"
            ]);
        }

        $credentials["email"] = strtolower($credentials["email"]);

        $status = User::where('email',$credentials["email"])->first();

        if($status){
            if($status->active == 0){
                return response()->json([
                    "error"=>true,
                    "message"=>"El usuario se encuentra inactivo en estos momentos."
                ]);
            }
        }else{
            return response()->json([
                "error"=>true,
                "message"=>"No se ha encontrado el usuario con el correo indicado."
            ]);
        }

        try {
            //si no se crea el token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(["error"=>true,
                                        "message"=>"Las credenciales son incorrectas"]);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ha ocurrido un error en el servidor'], 500);
        }

        $user = Auth::user();
        return response()->json(["user"=>$user,"token"=>$token]);

    }

    public function verify($code)
    {
        $user = User::where('confirmation_code', $code)->first();

        if (!$user) {
            return Redirect::to(env('FRONT_URL').'/login');
        }

        $user->email_verified_at = Carbon::now();
        $user->confirmation_code = null;
        $user->save();

        return Redirect::to(env('FRONT_URL').'/');
    }

    public function logout( Request $request ) {
        Auth::logout();
        $token = $request->header('Authorization');

        try {
            JWTAuth::parseToken()->invalidate( $token );
            return $this->success([],'Se ha cerrado la sesión correctamente');
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'Token expirado' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => 'Token inválido'
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'Falta el token' )
            ], 500 );
        }
    }

    public function resetPassword(Request $request) {
        try {
            $credentials = $request->only('email');

            if(!isset($credentials["email"])){
                return response()->json([
                    "error"=>true,
                    "message"=>"Debe ingresar un correo"
                ]);
            }

            $credentials["email"] = strtolower($credentials["email"]);

            $user = User::where('email',$credentials["email"])->first();

            if($user){
                if($user->active == 0){
                    return response()->json([
                        "error"=>true,
                        "message"=>"El usuario se encuentra inactivo en estos momentos."
                    ]);
                }
            }else{
                return response()->json([
                    "error"=>true,
                    "message"=>"No se ha encontrado el usuario con el correo indicado."
                ]);
            }

            $data = $user->toArray();
            $data['remember_token'] = Str::random(35);

            if ($data['remember_token']) {
                $user->remember_token = $data['remember_token'];
                $user->save();

                Mail::send('emails.reset_password', $data, function($message) use ($data) {
                    $message->to(strtolower($data['email']), $data['name'], $data['remember_token'])->subject('Por favor, no respondas el correo');
                });

                return $this->success([], "Se ha enviado a tu correo los pasos para recuperar tu acceso.");
            }
        } catch (\Exception $e) {
            $this->reportError($e);
            return response()->json($this->error("Ha ocurrido un error en el servidor",500,$e));
        }
    }

    public function setNewPassword(Request $request) {
        try {
            $attr = $request->all();

            if(!isset($attr["remember_token"]) || !isset($attr["password"])){
                return response()->json([
                    "error"=>true,
                    "message"=>"Debe tener un token y la nueva contraseña"
                ]);
            }

            $user = User::where('remember_token',$attr["remember_token"])->first();

            if($user){
                if($user->active == 0){
                    return response()->json([
                        "error"=>true,
                        "message"=>"El usuario se encuentra inactivo en estos momentos."
                    ]);
                }
            }else{
                return response()->json([
                    "error"=>true,
                    "message"=>"No se ha encontrado el usuario, asegurate de que tu token sea valido o prueba solicitar un nuevo restablecimiento de contraseña."
                ]);
            }

            $data = $user->toArray();

            if ($user->remember_token !== null) {
                $user->remember_token = null;
                $user->password = bcrypt($attr['password']);
                $user->save();

                Mail::send('emails.confirm_reset', $data, function($message) use ($data) {
                    $message->to(strtolower($data['email']), $data['name'])->subject('Por favor, no respondas el correo');
                });

                return $this->success([], "Enhorabuena tu contraseña ha sido restablecida correctamente.");
            } else {
                return $this->error("Ha ocurrido un error, el token no existe, vuelve a solicitar el restablecimiento de contraseña y sigue los pasos",200);
            }
        } catch (\Exception $e) {
            $this->reportError($e);
            return response()->json($this->error("Ha ocurrido un error en el servidor",500,$e));
        }
    }
}
