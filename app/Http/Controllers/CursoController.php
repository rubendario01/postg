<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CursoController extends Controller
{
    public function index(){
        return view('curso.curso_index');
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();
            if($request->accion==0){
                DB::table('curso')->insert([
                    'nombre' => $request->nombre ?? '',
                    'institucion' => $request->institucion ?? '',
                    'fecha' => $request->fecha ?? '',
                    'id_docente' => $request->id_docente ?? '',
  
    
                ]);
            }else{
                DB::table('curso')
                ->where('id', $request->id)
                ->update([
                    'nombre' => $request->nombre ?? '',
                    'institucion' => $request->institucion ?? '',
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
        $cursos = DB::table('curso')
        ->join('docente', 'docente.id', '=', 'curso.id_docente')
        ->select('curso.*', 'docente.nombre as nombre_docente')
        ->paginate(15);
        return $cursos;
    }

    public function eliminar(Request $request){
        try{
            DB::beginTransaction();
            DB::table('curso')->where('curso.id', $request->id)->delete();
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
