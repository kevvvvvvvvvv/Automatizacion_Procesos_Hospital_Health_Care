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
        Schema::create('hoja_riesgo_caidas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hoja_enfermeria_id')
                ->constrained('hoja_enfermerias')
                ->onDelete('cascade');

            $table->boolean('caidas_previas');
            $table->string('estado_mental');
            $table->string('deambulacion');
            $table->boolean('edad_mayor_70');
            $table->json('medicamentos')->nullable();
            $table->json('deficits')->nullable();
            $table->integer('puntaje_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_riesgo_caidas');
    }
};
