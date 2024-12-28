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
        Schema::create('comidas_empleados', function (Blueprint $table) {

            $table->id("id_registro");
            $table->string("nombre_cajero",255)->nullable();
            $table->string("cedula",255)->nullable();
            $table->string("nombre_empleado",255)->nullable();
            $table->integer("unidades")->nullable();
            $table->date("fecha")->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comidas_empleados');
    }
};
