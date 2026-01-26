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
        Schema::create('medicamento_vias', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('medicamento_id')
                ->constrained('medicamentos')
                ->onDelete('cascade');

            $table->foreignId('catalogo_via_administracion_id')
                ->constrained('catalogo_via_administracions')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamento_vias');
    }
};
