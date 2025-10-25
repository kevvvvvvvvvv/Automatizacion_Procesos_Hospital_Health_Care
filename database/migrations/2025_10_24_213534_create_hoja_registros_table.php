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
        Schema::create('hoja_registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoja_enfermeria_id')
                ->constrained('hoja_enfermerias')
                ->onDelete('cascade');
            $table->datetime('fecha_hora_registro');
            $table->integer('tension_arterial_sistolica');
            $table->integer('tension_arterial_diastolica');
            $table->integer('frecuencia_cardiaca');
            $table->integer('frecuencia_respiratoria');
            $table->decimal('temperatura');
            $table->integer('saturacion_oxigeno');
            $table->integer('glucemia_capilar');
            $table->decimal('peso');
            $table->integer('uresis');
            $table->string('uresis_descripcion', 255)->nullable();
            $table->integer('evacuaciones');
            $table->string('evacuaciones_descripcion', 255)->nullable();
            $table->integer('emesis');
            $table->string('emesis_descripcion', 255)->nullable();
            $table->integer('drenes');
            $table->string('drenes_descripcion', 255)->nullable();
            $table->string('estado_conciencia');
            $table->string('escala_braden');
            $table->string('escala_glasgow');
            $table->string('escala_eva');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_registros');
    }
};
