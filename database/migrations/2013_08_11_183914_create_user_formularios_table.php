<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario_formulario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_formulario');
            $table->foreignId('id_rol');
            $table->foreign('id_rol')->references('id')->on('rol');
            $table->foreign('id_formulario')->references('id')->on('formulario');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_formularios');
    }
};
