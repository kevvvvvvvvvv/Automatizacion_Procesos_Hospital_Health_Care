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
        Schema::create('hoja_terapia_i_v_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoja_terapia_id')
                ->constrained('hoja_terapias')
                ->onDelete('cascade');

            $table->foreignId('producto_servicio_id')
                ->nullable()
                ->constrained('producto_servicios')
                ->onDelete('cascade');

            $table->string('nombre_medicamento');

            $table->decimal('dosis', 10, 2); 
            
            $table->string('unidad_medida'); 


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_terapia_i_v_medicamentos');
    }
};
