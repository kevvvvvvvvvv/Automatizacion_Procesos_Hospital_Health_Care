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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            $table->string('curp', 18)->unique();

            $table->string('nombre', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100);
            $table->enum('sexo', ['Masculino', 'Femenino']);
            $table->date('fecha_nacimiento');

            $table->string('calle', 100);
            $table->string('numero_exterior', 50);
            $table->string('numero_interior', 50)->nullable();
            $table->string('colonia', 100);
            $table->string('municipio', 100);
            $table->string('estado', 100);
            $table->string('pais', 100);
            $table->string('cp', 10);

            $table->string('telefono', 20);
            $table->enum('estado_civil', ['Soltero(a)', 'Casado(a)', 'Divorciado(a)', 'Viudo(a)', 'Union libre']);
            $table->string('ocupacion', 100);
            $table->string('lugar_origen', 100);
            $table->string('nombre_padre')->nullable();
            $table->string('nombre_madre')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
