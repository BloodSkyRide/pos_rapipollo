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
        //
        Schema::create('sub_labores', function (Blueprint $table) {
            $table->id("id_sub_labor");
            $table->integer("id_labor");
            $table->string('nombre_sub_labor',255);
            $table->string('estado',255);
            $table->date('fecha_creacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('sub_labores');
    }
};
