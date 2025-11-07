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
        Schema::create('solicitud_dietas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoja_enfermeria_id')
                  ->constrained('hoja_enfermerias')
                  ->onDelete('cascade');

            $table->string('tipo_dieta'); // Ej: "Líquidos Claros", "Blanda - Desayuno"
            $table->string('opcion_seleccionada'); // Ej: "Opción 1: Omelette..."
            
            $table->datetime('horario_solicitud');
            $table->foreignId('user_supervisa_id')->nullable() // "Quién supervisó"
                  ->constrained('users')
                  ->onDelete('set null');
            
            $table->datetime('horario_entrega')->nullable();
            $table->foreignId('user_entrega_id')->nullable() // "Quién entrega"
                  ->constrained('users')
                  ->onDelete('set null');
            
            $table->datetime('horario_operacion')->nullable();
            $table->datetime('horario_termino')->nullable();
            $table->datetime('horario_inicio_dieta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_dietas');
    }
};
