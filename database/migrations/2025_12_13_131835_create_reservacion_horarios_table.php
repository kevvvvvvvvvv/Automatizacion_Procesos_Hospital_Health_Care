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
        Schema::create('reservacion_horarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservacion_id')
                ->constrained('reservaciones')
                ->cascadeOnDelete();

        $table->foreignId('habitacion_precio_id')
            ->constrained('habitacion_precios')
            ->onDelete('cascade');

        // Bloque exacto (ej: 2025-12-15 09:30:00)
        $table->dateTime('fecha_hora');

        $table->timestamps();

        // Un consultorio no puede repetir el mismo horario
        $table->unique(['habitacion_id', 'fecha_hora']);
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservacion_horarios');
    }
};
