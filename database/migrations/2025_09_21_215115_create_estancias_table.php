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
        Schema::create('estancias', function (Blueprint $table) {
            $table->bigIncrements('id_estancia');
            $table->date('fecha_ingreso');
            $table->date('fecha_egreso')->nullable();
            $table->string('num_habitacion')->nullable();
            $table->string('curpp');
            $table->foreign('curpp')
                ->references('curpp')
                ->on('pacientes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estancias');
    }
};
