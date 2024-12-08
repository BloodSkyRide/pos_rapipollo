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
        Schema::create('historial_notificaciones', function (Blueprint $table) {

            $table->id("id_notificacion");
            $table->string("id_user",255);
            $table->string("nombre",255)->nullable();
            $table->string("apellido",255)->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->time('hora_solicitud')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_final')->nullable();
            $table->date('fecha_notificacion')->nullable();
            $table->text('motivo')->nullable();
            $table->string('estado',100)->nullable();
            $table->timestamps();
            
        });
 }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_notificaciones');
    }
};
