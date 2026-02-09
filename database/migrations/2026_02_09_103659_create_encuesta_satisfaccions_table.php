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
        Schema::create('encuesta_satisfaccions', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');

            $table->integer('atencion_recpcion');
            $table->integer('trato_personal_enfermeria');
            $table->integer('limpieza_comodidad_habitacion');
            $table->integer('calidad_comida');
            $table->integer('tiempo_atencion');
            $table->integer('informacion_tratamiento');
            $table->boolean('atencion_nutricional');
            $table->text('comentarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta_satisfaccions');
    }
};
