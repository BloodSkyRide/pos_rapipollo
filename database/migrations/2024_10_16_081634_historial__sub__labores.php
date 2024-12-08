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
        Schema::create('historial_sub_labores', function (Blueprint $table) {
            $table->id("id_historial_sublabor");
            $table->string("id_user",255);
            $table->string("id_labor",255);
            $table->string('nombre_sub_labor',255);
            $table->string('estado',255);
            $table->date('fecha')->nullable();
            $table->time("hora")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_sub_labores');
    }
};
