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
            
            $table->date('fecha_cirugia')->nullable();
            $table->string('diagnostico_preoperatorio')->nullable();
            $table->string('plan_quirurgico')->nullable();
            $table->string('tipo_intervencion_quirurgica')->nullable();
            
            $table->string('riesgo_quirurgico')->nullable();
            $table->string('cuidados_plan_preoperatorios')->nullable();

            $table->string('pronostico')->nullable();
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
