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
        Schema::create('traslado', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');
             $table->string('ta');
            $table->integer('fc');
            $table->integer('fr');
            $table->decimal('peso', 8, 2);
            $table->integer('talla');
            $table->decimal('temp', 4, 2);
            
            $table->text('resultado_estudios');
            $table->text('tratamiento');
            $table->text('resumen_del_interrogatorio');
            $table->text('exploracion_fisica');
            $table->text('diagnostico_o_problemas_clinicos');
            $table->text('plan_de_estudio');
            $table->text('pronostico');
   
            $table->string('unidad_medica_envia');
            $table->string('unidad_medica_recibe');
            $table->text('motivo_translado');
            $table->text('impresion_diagnostica');
        
            $table->string('terapeutica_empleada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traslado');
    }
};
