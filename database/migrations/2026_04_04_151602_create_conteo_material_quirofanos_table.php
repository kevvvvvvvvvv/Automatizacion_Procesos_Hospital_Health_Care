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
        Schema::create('conteo_material_quirofanos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoja_enfermeria_quirofano_id')
                ->constrained('hoja_enfermeria_quirofanos')
                ->cascadeOnDelete();
            
            $table->string('tipo_material');
            $table->integer('cantidad_inicial')->default(0);
            $table->integer('cantidad_agregada')->default(0);
            $table->integer('cantidad_final')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conteo_material_quirofanos');
    }
};
