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
        Schema::create('catalogo_estudios', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('nombre'); 
            $table->string('tipo_estudio'); 
            $table->string('departamento')->nullable();
            $table->integer('tiempo_entrega');
            $table->decimal('costo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_estudios');
    }
};
