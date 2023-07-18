<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{

    public function login(Request $request){
        //Validación
        $credenciales=[
            'name'=> $request->name,
            'password'=> $request->password,
        ];

        if(Auth::attempt($credenciales)){
            $request->session()->regenerate();
            return redirect()->intended(route('inicio'));
        }else{
            return redirect()->route('loginSistema');
        }
        //dd($request->name, $request->password);
    }

    public function logout(Request $request){
        Auth::Logout();// Laravel cierra la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginSistema');
    }

    public function registroUsuario(Request $request){
        // Validar datos
        $user = new User();
        $user->name=$request->name;
        $user->password=Hash::make($request->password);
        $user->save();
        Auth::login($user);
        return view('inicio');
    }
}
