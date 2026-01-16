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
            $table->string('ta');
            $table->integer('fc');
            $table->integer('fr');
            $table->float('temp');
            $table->float('peso');
            $table->integer('talla');
            $table->string('motivo_atencion');
            $table->string('resumen_interrogatorio');
            $table->string('exploracion_fisica');
            $table->string('estado_mental');
            $table->string('resultados_relevantes');
            $table->string('diagnostico_problemas_clinicos');
            $table->string('tratamiento');
            $table->string('pronostico');
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
