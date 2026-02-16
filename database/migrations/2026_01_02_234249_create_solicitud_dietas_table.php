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

            $table->foreignId('dieta_id')
                ->constrained('dietas')
                ->onDelete('cascade');

            $table->string('estado');

            $table->datetime('horario_solicitud');

            $table->foreignId('user_supervisa_id')->nullable() // "Quién supervisó"
                  ->constrained('users')
                  ->onDelete('set null');
            
            $table->datetime('horario_entrega')->nullable();
            $table->foreignId('user_entrega_id')->nullable() // "Quién entrega"
                  ->constrained('users')
                  ->onDelete('set null');

            $table->string('observaciones')->nullable();
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
