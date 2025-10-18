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
        Schema::create('interconsultas', function (Blueprint $table) {  // Cambia 'interconsulta' a 'interconsultas' (plural)
            $table->id(); 

            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->text('criterio_diagnostico')->nullable(); 
            $table->text('plan_de_estudio')->nullable();
            $table->text('sugerencia_diagnostica')->nullable();
            $table->string('ta')->nullable(); 
            $table->integer('fc')->nullable();
            $table->integer('fr')->nullable();
            $table->decimal('temp', 5, 2)->nullable(); 
            $table->decimal('peso', 6, 2)->nullable();
            $table->decimal('talla', 4, 2)->nullable();
            $table->text('motivo_de_la_atencion_o_interconsulta')->nullable();
            $table->text('resumen_del_interrogatorio')->nullable();
            $table->text('exploracion_fisica')->nullable();
            $table->text('estado_mental')->nullable();
            $table->text('resultados_relevantes_del_estudio_diagnostico')->nullable();
            $table->text('diagnostico_o_problemas_clinicos')->nullable();
            $table->text('tratamiento_y_pronostico')->nullable();

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interconsultas');  // Cambia aquí también a plural
    }
};
