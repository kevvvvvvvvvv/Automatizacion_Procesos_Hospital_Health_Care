<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_servicio'); 
            $table->text('comentarios')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('resultado_aceptado')->nullable(); 
            
            // Tiempos en segundos (Integers son mejores para cálculos matemáticos)
            $table->integer('duracion_espera')->default(0);
            $table->integer('duracion_actividad')->default(0);

            // Relaciones
            $table->foreignId('habitacion_id')->constrained('habitaciones')->onDelete('cascade');
            $table->foreignId('user_solicita_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_ejecuta_id')->nullable()->constrained('users')->onDelete('cascade');

            // Fechas clave (Nombres sincronizados con tu interface de TS)
            $table->timestamp('fecha_solicita')->nullable(); // Cuando inicia el traslado
            $table->timestamp('fecha_arregla')->nullable();  // Cuando llega al sitio
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};