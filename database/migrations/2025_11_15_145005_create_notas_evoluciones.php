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
            $table->text('evolucion_actualizacion');  
            $table->string('ta');
            $table->integer('fc');  
            $table->integer('fr'); 
            $table->decimal('temp', 5, 2)->nullable();  
            $table->decimal('peso', 5, 2)->nullable(); 
            $table->decimal('talla', 5, 2)->nullable();  

            $table->text('resultado_estudios')->nullable();
            $table->text('resumen_del_interrogatorio')->nullable();
            $table->text('exploracion_fisica')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('diagnostico_o_problemas_clinicos')->nullable();
            $table->text('plan_de_estudio')->nullable();
            $table->text('pronostico')->nullable();
            
            $table->text('manejo_dieta')->nullable();
            $table->text('manejo_soluciones')->nullable(); 
            $table->text('manejo_medicamentos')->nullable(); 
            $table->text('manejo_laboratorios')->nullable(); 
            $table->text('manejo_medidas_generales')->nullable();

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