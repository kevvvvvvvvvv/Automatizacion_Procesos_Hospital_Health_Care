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
        Schema::create('indicacion_medicamentos', function (Blueprint $table) {
            $table->id();

            $table->morphs('itemable');
            
            $table->foreignId('producto_servicio_id')
                  ->nullable()
                  ->constrained('producto_servicios')
                  ->nullOnDelete(); 
            $table->string('nombre_medicamento');

            $table->integer('dosis'); 
            $table->string('gramaje'); 
            $table->string('unidad'); 
            $table->string('via_administracion')->nullable();
            $table->string('duracion_tratamiento'); 
            $table->string('razon_necesaria');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicacion_medicamentos');
    }
};
