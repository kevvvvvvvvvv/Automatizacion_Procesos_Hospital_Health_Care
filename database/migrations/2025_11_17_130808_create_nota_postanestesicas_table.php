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
        Schema::create('nota_postanestesicas', function (Blueprint $table) {
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
            $table->string('resumen_del_interrogatorio');
            $table->string('exploracion_fisica');
            $table->string('resultado_estudios');
            $table->string('diagnostico_o_problemas_clinicos');
            $table->string('plan_de_estudio');
            $table->string('pronostico');
            $table->string('tratamiento');

            $table->text('resumen_del_interrogatorio');
            $table->text('exploracion_fisica');
            $table->text('resultado_estudios');
            $table->text('diagnostico_o_problemas_clinicos');
            $table->text('plan_de_estudio');
            $table->text('pronostico');

            $table->text('tecnica_anestesica');
            $table->text('farmacos_administrados');
            $table->time('duracion_anestesia');
            $table->text('incidentes_anestesia');
            $table->text('balance_hidrico');
            $table->text('estado_clinico');
            $table->text('plan_manejo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_postanestesicas');
    }
};
