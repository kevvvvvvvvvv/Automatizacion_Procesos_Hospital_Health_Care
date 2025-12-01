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
        Schema::create('hoja_generals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hoja_enfermeria_quirofano_id')
                ->constrained('hoja_enfermeria_quirofanos')
                ->onDelete('cascade');

            $table->datetime('hora_inicio_cirugia');
            $table->datetime('hora_inicio_anestesia');
            $table->datetime('hora_inicio_paciente');
            $table->datetime('hora_fin_cirugia');
            $table->datetime('hora_fin_anestesia');
            $table->datetime('hora_fin_paciente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_generals');
    }
};
