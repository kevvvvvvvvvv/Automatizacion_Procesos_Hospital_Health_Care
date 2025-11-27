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
             $table->string('ta')->nullable();
            $table->integer('fc')->nullable();
            $table->integer('fr')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->decimal('talla', 4, 2)->nullable();
            $table->decimal('temp', 4, 2)->nullable();

            $table->text('resumen_del_interrogatorio')->nullable();
            $table->text('exploracion_fisica')->nullable();
            $table->text('diagnostico_o_problemas_clinicos')->nullable();
            $table->text('plan_de_estudio')->nullable();
            $table->text('pronostico')->nullable();
   
            $table->string('unidad_medica_envia')->nullable();
            $table->string('unidad_medica_recibe')->nullable();
            $table->text('motivo_translado')->nullable();
            $table->text('impresion_diagnostica')->nullable();
        
            $table->string('terapeutica_empleada')->nullable();
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
