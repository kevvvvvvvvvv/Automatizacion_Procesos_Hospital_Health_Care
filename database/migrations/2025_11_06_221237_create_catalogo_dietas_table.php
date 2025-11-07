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
        Schema::create('catalogo_dietas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_dieta'); 
            $table->string('opcion_nombre'); 
            $table->boolean('es_apto_diabetico')->default(true);
            $table->boolean('es_apto_celiaco')->default(true); 
            $table->boolean('es_apto_hipertenso')->default(true);
            $table->boolean('es_apto_colecisto')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_dietas');
    }
};
