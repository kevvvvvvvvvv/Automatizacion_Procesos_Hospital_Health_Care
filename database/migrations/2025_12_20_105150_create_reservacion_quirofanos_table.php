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
        Schema::create('reservacion_quirofanos', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('habitacion_id')
                ->nullable()
                ->constrained('habitaciones')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('estancia_id')
                ->nullable()
                ->constrained('estancias')
                ->cascadeOnDelete();

            // Datos principales
            $table->string('paciente')->nullable(); // Nombre manual para externos o copia del nombre de estancia
            $table->string('tratante');
            $table->string('procedimiento');
            $table->string('tiempo_estimado');
            $table->string('medico_operacion'); // El Cirujano

            // Detalles requeridos (Si son NULL significa que se seleccionó "NO" en el formulario)
            $table->text('laparoscopia_detalle')->nullable(); // Agregado para el formulario
            $table->text('instrumentista')->nullable();
            $table->text('anestesiologo')->nullable();
            $table->text('insumos_medicamentos')->nullable();
            $table->text('esterilizar_detalle')->nullable();
            $table->text('rayosx_detalle')->nullable();
            $table->text('patologico_detalle')->nullable();
            
            // Notas y Agenda
            $table->text('comentarios')->nullable();
            $table->json('horarios'); // Se guarda como array gracias al cast en el Modelo
            $table->date('fecha');
            $table->string('localizacion')->nullable(); // Quirófano 1, Quirófano 2, etc.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservacion_quirofanos');
    }
};