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
        Schema::create('cirugia_seguras', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade'); 
            $table->string('servicio_procedencia');
            $table->string('cirugia_programada');
            $table->string('cirugia_realizada');
            $table->string('grupo_rh');
            $table->boolean('confirmar_indentidad')->nullable()->default(false);
            $table->boolean('sitio_quirurgico')->nullable()->default(false);
            $table->boolean('funcionamiento_aparatos')->nullable()->default(false);
            $table->boolean('oximetro')->nullable()->default(false);
            $table->string('alergias');
            $table->boolean('via_aerea')->nullable()->default(false);
            $table->boolean('riesgo_hemorragia')->nullable()->default(false);
            $table->boolean('hemoderivados')->nullable()->default(false);
            $table->boolean('profilaxis')->nullable()->default(false);
            $table->boolean('miembros_equipo')->nullable()->default(false);
            $table->boolean('indentidad_paciente')->nullable()->default(false);
            $table->string('pasos_criticos');
            $table->float('tiempo_aproximado');
            $table->float('perdida_sanguinea');
            $table->boolean('revision_anestesiologo')->nullable()->default(false);
            $table->boolean('esterilizacion')->nullable()->default(false);
            $table->boolean('dudas_problemas')->nullable()->default(false);
            $table->boolean('imagenes_diagnosticas')->nullable()->default(false);
            $table->boolean('nombre_procedimiento')->nullable()->default(false);
            $table->boolean('recuento_instrumentos')->nullable()->default(false);
            $table->boolean('faltantes')->nullable()->default(false);
            $table->string('observaciones');
            $table->boolean('etiquetado_muestras')->nullable()->default(false);
            $table->string('aspectos_criticos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cirugia_seguras');
    }
};
