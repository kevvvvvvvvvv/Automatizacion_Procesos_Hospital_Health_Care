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
        Schema::create('catalogo_preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta');
            $table->integer('orden');
            $table->string('categoria');
            
            $table->foreignId('formulario_catalogo_id')
                ->constrained('formulario_catalogos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalago_preguntas');
    }
};
