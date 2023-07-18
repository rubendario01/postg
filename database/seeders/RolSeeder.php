<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('rol')->insert(
            [
                'id'=>1,
                'nombre'=>'Cliente'
            ]
        );
        DB::table('rol')->insert(
            [
                'id'=>2,
                'nombre'=>'Empleado'
            ]
        );
        DB::table('rol')->insert(
            [
                'id'=>3,
                'nombre'=>'Administrador'
            ]
        );
    }
}
