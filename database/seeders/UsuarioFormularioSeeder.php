<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UsuarioFormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // rol cliente
        DB::table('usuario_formulario')->insert(
            [
                'id'=>1,
                'id_formulario'=>1,
                'id_rol'=>1
            ]
        );
        
        // rol empleado
        DB::table('usuario_formulario')->insert(

            [
                'id'=>2,
                'id_formulario'=>2,
                'id_rol'=>2
            ]
        );
            // rol administrador
        DB::table('usuario_formulario')->insert(
            [
                'id'=>3,
                'id_formulario'=>1,
                'id_rol'=>3
            ]
        );
        DB::table('usuario_formulario')->insert(
            [
                'id'=>4,
                'id_formulario'=>2,
                'id_rol'=>3
            ]
        );
    }
}
