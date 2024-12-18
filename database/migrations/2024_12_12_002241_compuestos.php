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
        Schema::create('compuestos', function (Blueprint $table) {

            $table->id("id_compuesto");
            $table->integer("id_producto_venta");
            $table->string("nombre_compuesto",255);
            $table->integer("id_item_fk");
            $table->float("descuento")->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compuestos');
    }
};
