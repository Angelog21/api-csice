<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        try {
            $attr = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
                'password_confirm' => 'required|string|min:6',
                'rif' => 'required|string',
                'social_reason' => 'required|string',
                'direction' => 'required|string',
                'phone' => 'required|string'
            ]);
            
            if(!isset($request->role)){
                $role = 4;
            }else{
                $role = $request->role;
            }

            if(User::where('email',$attr["email"])->exists()){
                return $this->error("Usuario ya existe",400,[]);
            }
    
            $user = User::create([
                'name' => $attr['name'],
                'social_reason' => $attr['social_reason'],
                'phone' => $attr['phone'],
                'rif' => $attr['rif'],
                'direction' => $attr['direction'],
                'password' => bcrypt($attr['password']),
                'email' => $attr['email'],
                'role_id' => $role
            ]);
    
            return $this->success(["user"=>$user],"Usuario registrado correctamente");
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

    public function logout(){
        Auth::logout();
        return $this->success([],'Se ha cerrado la sesión correctamente');
    }
}