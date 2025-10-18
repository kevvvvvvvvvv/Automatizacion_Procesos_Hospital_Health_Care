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
        Schema::create('respuesta_formularios', function (Blueprint $table) {
            $table->id();

            $table->json('detalles');

            $table->foreignId('catalogo_pregunta_id')
                ->constrained('catalogo_preguntas')
                ->onDelete('cascade');

            $table->foreignId('historia_clinica_id')
                ->constrained('historia_clinicas')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta_formularios');
    }
};
