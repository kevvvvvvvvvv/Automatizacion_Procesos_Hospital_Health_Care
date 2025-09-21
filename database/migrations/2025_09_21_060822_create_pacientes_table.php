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
            $table->string('curpp',18)->primary();
            $table->string('nombre',100);
            $table->string('apellidop',100);
            $table->string('apellidom',100);
            $table->enum('sexo',['Masculino','Femenino']);
            $table->date('fechaNacimiento');
            $table->string('calle',100);
            $table->string('numeroExterior',50);
            $table->string('numeroInterior',50)->nullable();
            $table->string('colonia',100);
            $table->string('municipio',100);
            $table->string('estado',100);
            $table->string('pais',100);
            $table->string('cp',100);
            $table->string('telefono',20);
            $table->enum('estadoCivil', ['soltero(a)', 'casado(a)', 'divorciado(a)', 'viudo(a)', 'union_libre']);
            $table->string('ocupacion',100);
            $table->string('lugarOrigen',100);
            $table->string('nombrePadre')->nullable();
            $table->string('nombreMadre')->nullable();

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
