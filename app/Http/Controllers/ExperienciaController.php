<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ExperienciaController extends Controller
{
    public function index(){
        return view('experiencia.experiencia_index');
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();
            if($request->accion==0){
                DB::table('experiencia')->insert([
                    'empresa' => $request->empresa ?? '',
                    'cargo' => $request->cargo ?? '',
                    'fecha_inicio' => $request->fecha_inicio ?? '',
                    'fecha_fin' => $request->fecha_fin ?? '',
                    'id_docente' => $request->id_docente ?? '',
    
                ]);
            }else{
                DB::table('experiencia')
                ->where('id', $request->id)
                ->update([
                    'empresa' => $request->empresa ?? '',
                    'cargo' => $request->cargo ?? '',
                    'fecha_inicio' => $request->fecha_inicio ?? '',
                    'fecha_fin' => $request->fecha_fin ?? '',
                    'id_docente' => $request->id_docente ?? '',
                ]);
        
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }

    public function listar(Request $request){
        $experiencias = DB::table('experiencia')
        ->join('docente', 'docente.id', '=', 'experiencia.id_docente')
        ->select('experiencia.*', 'docente.nombre as nombre_docente')
        ->paginate(15);
        return $experiencias;
    }

    public function eliminar(Request $request){
        try{
            DB::beginTransaction();
            DB::table('experiencia')->where('experiencia.id', $request->id)->delete();
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
