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

            $table->text('motivo_atencion');
            $table->text('resumen_interrogatorio');
            $table->text('exploracion_fisica');
            $table->text('estado_mental');
            $table->text('resultados_relevantes');
            $table->text('diagnostico_problemas_clinicos');
            $table->text('tratamiento');
            $table->text('pronostico');

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
