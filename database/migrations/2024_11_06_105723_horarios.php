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
        Schema::create('horarios', function (Blueprint $table) {

            $table->id("id_horario");
            $table->string("id_user");
            $table->string("nombre",255)->nullable();
            $table->string("apellido",255)->nullable();
            $table->string('lunes',255)->nullable();
            $table->string('aseo-lunes',255)->nullable();
            $table->string('martes',255)->nullable();
            $table->string('aseo-martes',255)->nullable();
            $table->string('miercoles',255)->nullable();
            $table->string('aseo-miercoles',255)->nullable();
            $table->string('jueves',255)->nullable();
            $table->string('aseo-jueves',255)->nullable();
            $table->string('viernes',255)->nullable();
            $table->string('aseo-viernes',255)->nullable();
            $table->string('sabado',255)->nullable();
            $table->string('aseo-sabado',255)->nullable();
            $table->string('domingo',255)->nullable();
            $table->string('aseo-domingo',255)->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
