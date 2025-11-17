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
        Schema::create('nota_postoperatorias', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');

            $table->datetime('hora_inicio_operacion');
            $table->datetime('hora_termino_operacion');

            $table->text('diagnostico_preoperatorio');
            $table->text('operacion_planeada');
            $table->text('operacion_realizada');
            $table->text('diagnostico_postoperatorio');
            $table->text('descripcion_tecnica_quirurgica');
            $table->text('hallazgos_transoperatorios');
            $table->text('reporte_conteo');
            $table->text('incidentes_accidentes');
            $table->text('cuantificacion_sangrado');
            $table->text('estudios_transoperatorios');
            
            $table->text('estado_postquirurgico');
            $table->text('manejo_dieta')->nullable();
            $table->text('manejo_soluciones')->nullable();
            $table->text('manejo_medicamentos')->nullable();
            $table->text('manejo_medidas_generales')->nullable();
            $table->text('manejo_laboratorios')->nullable();
            $table->text('pronostico');
            $table->text('envio_piezas');
            $table->text('hallazgos_importancia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_postoperatorias');
    }
};
