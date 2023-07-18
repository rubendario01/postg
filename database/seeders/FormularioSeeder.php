<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class FormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('formulario')->insert(
            [
                'id'=>1,
                'nombre'=>'cliente',
                'imagen'=>'/public/formulario/default.png',
                'ruta'=>'/cliente/index'
            ]
        );

        DB::table('formulario')->insert(
            [
                'id'=>2,
                'nombre'=>'empleado',
                'imagen'=>'/public/formulario/default.png',
                'ruta'=>'/empleado/index'
            ]
        );
    }
}
