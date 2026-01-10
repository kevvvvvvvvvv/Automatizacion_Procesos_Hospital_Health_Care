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

            $table->integer('tension_arterial_sistolica')->nullable();
            $table->integer('tension_arterial_diastolica')->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->decimal('temperatura')->nullable();
            $table->integer('saturacion_oxigeno')->nullable();
            $table->integer('glucemia_capilar')->nullable();
            $table->decimal('talla')->nullable();
            $table->decimal('peso')->nullable();

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
