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
        Schema::create('solicitud_patologias', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');

            $table->foreignId('user_solicita_id') 
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->date('fecha_estudio');
            $table->string('estudio_solicitado'); 
            $table->string('biopsia_pieza_quirurgica');
            $table->string('revision_laminillas');
            $table->string('estudios_especiales');
            $table->string('pcr');
            $table->string('pieza_remitida');
            
            $table->text('datos_clinicos'); 
            $table->text('resultados')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_patologias');
    }
};
