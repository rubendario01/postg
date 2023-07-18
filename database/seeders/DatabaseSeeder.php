<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolSeeder;
use Database\Seeders\FormularioSeeder;
use Database\Seeders\UsuarioFormularioSeeder;
use Database\Seeders\UserSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $this->call(RolSeeder::class);
        $this->call(FormularioSeeder::class);
        $this->call(UsuarioFormularioSeeder::class);
        $this->call(UserSeeder::class);
    }
}
