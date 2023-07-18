<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RolController extends Controller
{
    public function index(Request $request){
        return view('roles.rol_index');
    }
    public function getRoles(){
        $roles = DB::table('rol')->paginate(10);
        return $roles;
    }

    public function setRol(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->opcion == 0) {
                DB::table('rol')->insert([
                    'nombre' => $request->nombre,
                ]);
            } else {
                DB::table('rol')->where('id', $request->id)->update([
                    'nombre' => $request->nombre,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function eliminar(Request $request)
    {
        DB::table('rol')->where('id', $request->id)->delete();
    }

}
