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
        Schema::create('historia_clinicas', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade'); 

            $table->text('padecimiento_actual');
            $table->string('tension_arterial');
            $table->integer('frecuencia_cardiaca');
            $table->integer('frecuencia_respiratoria');
            $table->float('temperatura');
            $table->float('peso');
            $table->integer('talla');

            $table->text('resultados_previos');
            $table->text('diagnostico');
            $table->text('pronostico');
            $table->text('indicacion_terapeutica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_clinicas');
    }
};
