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
        Schema::create('hoja_enfermeria_quirofanos', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');

            $table->datetime('hora_inicio_cirugia')->nullable();
            $table->datetime('hora_inicio_anestesia')->nullable();
            $table->datetime('hora_inicio_paciente')->nullable();
            $table->datetime('hora_fin_cirugia')->nullable();
            $table->datetime('hora_fin_anestesia')->nullable();
            $table->datetime('hora_fin_paciente')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_enfermeria_quirofanos');
    }
};
