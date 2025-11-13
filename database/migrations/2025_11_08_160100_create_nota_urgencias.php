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
        Schema::create('nota_urgencias', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');
            $table->string('ta')->nullable();
            $table->integer('fc')->nullable();
            $table->integer('fr')->nullable();
            $table->float('temp')->nullable();
            $table->float('peso')->nullable();
            $table->float('talla')->nullable();
            $table->string('motivo_atencion')->nullable();
            $table->string('resumen_interrogatorio')->nullable();
            $table->string('exploracion_fisica')->nullable();
            $table->string('estado_mental')->nullable();
            $table->string('resultados_relevantes')->nullable();
            $table->string('diagnostico_problemas_clinicos')->nullable();
            $table->string('tratamiento')->nullable();
            $table->string('pronostico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_urgencias');
    }
};
