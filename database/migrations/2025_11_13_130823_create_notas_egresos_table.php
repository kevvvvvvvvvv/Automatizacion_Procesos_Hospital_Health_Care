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

            $table->text('diagnosticos_finales');
            $table->text('resumen_evolucion_estado_actual');
            $table->text('manejo_durante_estancia');
            $table->text('problemas_pendientes');
            $table->text('plan_manejo_tratamiento');
            $table->text('recomendaciones');
            $table->text('factores_riesgo');
            $table->text('pronostico');
            $table->text('defuncion')->nullable();

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
