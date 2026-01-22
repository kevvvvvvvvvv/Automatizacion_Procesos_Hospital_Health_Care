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
        Schema::create('preoperatorios', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');
            
            $table->date('fecha_cirugia');
            $table->text('diagnostico_preoperatorio');
            $table->text('plan_quirurgico');
            $table->text('tipo_intervencion_quirurgica');
             $table->string('ta');
            $table->integer('fc');
            $table->integer('fr');
            $table->decimal('peso', 8, 2);
            $table->integer('talla');
            $table->decimal('temp', 4, 2);
            
            $table->text('resultado_estudios');
            $table->text('resumen_del_interrogatorio');
            $table->text('exploracion_fisica');
            $table->text('diagnostico_o_problemas_clinicos');
            $table->text('plan_de_estudio');
            $table->text('pronostico');
            $table->text('tratamiento');
   
            $table->string('riesgo_quirurgico');
            $table->text('cuidados_plan_preoperatorios');

            $table->timestamps();
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preoperatorios');
    }
};
