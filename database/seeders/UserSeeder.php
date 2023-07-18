<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert(
            [
                'id'=>1,
                'name'=>'administrador',
                'password'=>'$2a$12$ClOrb9HMgtGZEJX2Ccc33.HjoIE.nFKBFFtxZvIBRSQrUAleASEpG',//admin
                'id_rol'=>3
            ]
        );
        DB::table('users')->insert(
            [
                'id'=>2,
                'name'=>'cliente',
                'password'=>'$2a$12$ClOrb9HMgtGZEJX2Ccc33.HjoIE.nFKBFFtxZvIBRSQrUAleASEpG',//admin
                'id_rol'=>1
            ]
        );
        DB::table('users')->insert
        (
            [
                'id'=>3,
                'name'=>'empleado',
                'password'=>'$2a$12$ClOrb9HMgtGZEJX2Ccc33.HjoIE.nFKBFFtxZvIBRSQrUAleASEpG',//admin
                'id_rol'=>2
            ]
        );
    }
}
