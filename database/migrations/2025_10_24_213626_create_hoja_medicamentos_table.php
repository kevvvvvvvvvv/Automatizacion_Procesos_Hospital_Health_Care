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
        Schema::create('hoja_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoja_enfermeria_id')
                ->constrained('hoja_enfermerias')
                ->onDelete('cascade');
            $table->foreignId('producto_servecio_id')
                ->constrained('producto_servicios')
                ->onDelete('cascade');

            $table->string('dosis');
            $table->string('via_administracion');
            $table->integer('duracion_tratamiento');
            $table->datetime('fecha_hora_inicio');
            $table->string('estado')->default('solicitado');
            $table->datetime('fecha_hora_solicitud');
            $table->datetime('fecha_hora_surtido_farmacia')->nullable();
            
            $table->foreignId('farmaceutico_id')->nullable()
                ->constrained('users') 
                ->onDelete('set null');
            $table->datetime('fecha_hora_recibido_enfermeria')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_medicamentos');
    }
};
