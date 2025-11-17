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
        Schema::create('notas_evoluciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade'); 
            $table->string('evolucion_actualizacion');  // Texto para evolución/actualización
            $table->string('ta');
            $table->string('fc');  
            $table->string('fr'); 
            $table->decimal('temp', 5, 2)->nullable();  
            $table->decimal('peso', 5, 2)->nullable(); 
            $table->decimal('talla', 5, 2)->nullable();  
            $table->text('resultados_relevantes');  
            $table->text('diagnostico_problema_clinico');  
            $table->string('pronostico'); 
            $table->text('tratammimento_indicaciones_medicas');  
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_evoluciones');
    }
};