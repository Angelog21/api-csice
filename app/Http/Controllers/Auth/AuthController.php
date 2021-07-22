<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

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

            if(User::where('email',$attr["email"])->exists()){
                return $this->error("Usuario ya existe",400,[]);
            }

            $attr["confirmation_code"] = Str::random(35);
    
            $user = User::create([
                'name' => $attr['name'],
                'social_reason' => $attr['social_reason'],
                'phone' => $attr['phone'],
                'rif' => $attr['rif'],
                'direction' => $attr['direction'],
                'password' => bcrypt($attr['password']),
                'email' => $attr['email'],
                'role_id' => $attr["role"],
                'confirmation_code'=>$attr["confirmation_code"]
            ]);

            Mail::send('emails.confirmation_code', $attr, function($message) use ($attr) {
                $message->to($attr['email'], $attr['name'])->subject('Por favor confirma tu correo');
            });
    
            return $this->success(["user"=>$user],"Usuario registrado correctamente debe verificar.");
        } catch (\Exception $e) {
            return $this->error($e->message,500,$e);
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            return response()->json(["user"=>$user]);
        }

        return response()->json([
            "error"=>true,
            "message"=>"Error, credenciales no válidas"
        ]);
    }

    public function verify($code)
    {
        $user = User::where('confirmation_code', $code)->first();

        if (!$user)
            return $this->error("No se encontró el user",404,["success"=>false]);

        $user->email_verified_at = Carbon::now();
        $user->confirmation_code = null;
        $user->save();

        return Redirect::to(env('FRONT_URL').'/');
    }

    public function logout(){
        Auth::logout();
        return $this->success([],'Se ha cerrado la sesión correctamente');
    }
}