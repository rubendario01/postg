<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DocenteController extends Controller
{
    public function index(){
        return view('docente.docente_index');
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();
            if($request->accion==0){
                DB::table('docente')->insert([
                    'nombre' => $request->nombre ?? '',
                    'paterno' => $request->paterno ?? '',
                    'materno' => $request->materno ?? '',
                    'carnet' => $request->carnet ?? '',
                    'telefono' => $request->telefono ?? '',
                    'correo' => $request->correo ?? '',
                    'lugar_nacimiento' => $request->lugar_nacimiento ?? '',
                    'disponibilidad' => $request->disponibilidad ?? '',
                    'direccion' => $request->direccion ?? '',
                    'fecha_nacimiento' => $request->fecha_nacimiento ?? '',
                ]);
            }else{
                DB::table('docente')
                ->where('id', $request->id)
                ->update([
                    'nombre' => $request->nombre ?? '',
                    'paterno' => $request->paterno ?? '',
                    'materno' => $request->materno ?? '',
                    'carnet' => $request->carnet ?? '',
                    'telefono' => $request->telefono ?? '',
                    'correo' => $request->correo ?? '',
                    'lugar_nacimiento' => $request->lugar_nacimiento ?? '',
                    'disponibilidad' => $request->disponibilidad ?? '',
                    'direccion' => $request->direccion ?? '',
                    'fecha_nacimiento' => $request->fecha_nacimiento ?? '',
                ]);
        
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }

    public function listar(Request $request){
        $docentes = DB::table('docente')->paginate(15);
        return $docentes;
    }

    public function eliminar(Request $request){
        try{
            DB::beginTransaction();
            DB::table('docente')->where('docente.id', $request->id)->delete();
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
   
}
