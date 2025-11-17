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
           Schema::create('nota_egresos', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');
            $table->String('motivo_egreso');
            $table->string('diagnosticos_finales');
            $table->string('resumen_evolucion_estado_actual');
            $table->string('manejo_durante_estancia');
            $table->string('problemas_pendientes');
            $table->string('plan_manejo_tratamiento');
            $table->string('recomendaciones');
            $table->string('factores_riesgo');
            $table->string('pronostico');
            $table->string('defuncion');
             $table->timestamps();
           });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_egresos');
    }
};
