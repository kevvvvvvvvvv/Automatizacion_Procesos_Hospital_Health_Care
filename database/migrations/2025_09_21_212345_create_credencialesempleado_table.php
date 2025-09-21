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
        Schema::create('credencialesempleado', function (Blueprint $table) {
            $table->bigIncrements('id_credenciales_empleado');
            $table->string('titulo',100);
            $table->string('cedula_profesional',100);
            $table->string('curpc',18);
            $table->foreign('curpc')
                ->references('curpc')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credencialesempleado');
    }
};
