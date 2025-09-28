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
        Schema::create('estancias', function (Blueprint $table) {

            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('paciente_id')
                  ->constrained('pacientes')
                  ->onDelete('cascade');

            $table->datetime('fecha_ingreso');
            $table->datetime('fecha_egreso')->nullable();
            $table->string('num_habitacion')->nullable();
            $table->enum('tipo_estancia', ['Interconsulta', 'Hospitalizacion']);

            $table->foreignId('estancia_anterior_id')
                  ->nullable()
                  ->constrained('estancias')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estancias');
    }
};
