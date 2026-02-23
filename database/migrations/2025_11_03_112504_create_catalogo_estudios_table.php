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
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->integer('codigo')->nullable();
            $table->string('nombre'); 
            $table->string('tipo_estudio'); 
            $table->string('departamento');
            $table->integer('tiempo_entrega')->nullable();
            $table->decimal('costo')->default('0.01');
            $table->string('clave_producto_servicio')->nullable();
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
