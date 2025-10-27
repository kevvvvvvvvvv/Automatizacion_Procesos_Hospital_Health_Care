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
        Schema::create('hoja_terapias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoja_enfermeria_id')
                ->constrained('hoja_enfermerias')
                ->onDelete('cascade');
            $table->foreignId('solucion')
                ->constrained('producto_servicios')
                ->onDelete('cascade');
            $table->decimal('flujo_ml_hora');
            $table->datetime('fecha_hora_inicio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_terapias');
    }
};
