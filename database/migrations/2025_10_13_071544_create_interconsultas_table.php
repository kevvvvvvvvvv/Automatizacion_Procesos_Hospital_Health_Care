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
        Schema::create('interconsultas', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade'); 
            $table->text('criterio_diagnostico'); 
            $table->text('plan_de_estudio');
            $table->text('sugerencia_diagnostica');
            $table->string('ta'); 
            $table->integer('fc');
            $table->integer('fr');
            $table->decimal('temp', 5, 2); 
            $table->decimal('peso', 6, 2);
            $table->integer('talla');
            $table->text('motivo_de_la_atencion_o_interconsulta');
            $table->text('resumen_del_interrogatorio');
            $table->text('exploracion_fisica');
            $table->text('estado_mental');
            $table->text('resultados_relevantes_del_estudio_diagnostico');
            $table->text('diagnostico_o_problemas_clinicos');
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
        Schema::dropIfExists('interconsultas'); // Elimina la tabla en rollback
    }
};
