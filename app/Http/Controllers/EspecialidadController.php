<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class EspecialidadController extends Controller
{
    public function index(){
        return view('especialidad.especialidad_index');
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();
            if($request->accion==0){
                DB::table('especialidad')->insert([
                    'nombre' => $request->nombre ?? '',
                    'tipo' => $request->tipo ?? '',
                    'pais' => $request->pais ?? '',
                    'ciudad' => $request->ciudad ?? '',
                    'fecha' => $request->fecha ?? '',
                    'id_docente' => $request->id_docente ?? '',
    
                ]);
            }else{
                DB::table('especialidad')
                ->where('id', $request->id)
                ->update([
                    'nombre' => $request->nombre ?? '',
                    'tipo' => $request->tipo ?? '',
                    'pais' => $request->pais ?? '',
                    'ciudad' => $request->ciudad ?? '',
                    'fecha' => $request->fecha ?? '',
                    'id_docente' => $request->id_docente ?? '',
                ]);
        
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }

    public function listar(Request $request){
        $especialidades = DB::table('especialidad')
        ->join('docente', 'docente.id', '=', 'especialidad.id_docente')
        ->select('especialidad.*', 'docente.nombre as nombre_docente')
        ->paginate(15);
        return $especialidades;
    }

    public function eliminar(Request $request){
        try{
            DB::beginTransaction();
            DB::table('especialidad')->where('especialidad.id', $request->id)->delete();
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
    public function listarDocentes(){
        $docentes = DB::table('docente')->get();
        return $docentes;
    }
}
