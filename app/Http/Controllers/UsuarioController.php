<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use DB;
class UsuarioController extends Controller
{
    public function index(Request $request){
        return view('users.usuario_index');
    }

    public function getUsuarios(){
        $usuarios = DB::table('users')
        ->join('rol', 'rol.id', '=', 'users.id_rol')
        ->select('users.name', 'rol.nombre as role', 'users.id_rol', 'users.id')
        ->orderBy('users.id', 'desc')
        ->paginate(10);

        return response()->json($usuarios);
    }

    public function setUsuario(Request $request){
        //dd($request);
        try{

            DB::beginTransaction();
            if($request->opcion==0){
                DB::table('users')->insert([
                    'name'=>$request->nombre,
                    'password'=>Hash::make($request->password),
                    'id_rol'=>$request->id_rol,
                ]);
            }else{
                DB::table('users')->where('users.id', $request->id)->update([
                    'name'=>$request->nombre,
                    'password'=>Hash::make($request->password),
                    'id_rol'=>$request->id_rol,
                ]);
            }

            DB::commit();
            
        }catch(Exception $e){
            DB::rollback();
        }

    }

    public function eliminarUsuario(Request $request){
        $usuario = DB::table('users')->where('users.id', $request->id);
        $usuario->delete();
    }
}
