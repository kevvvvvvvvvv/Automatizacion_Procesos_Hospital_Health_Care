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
        Schema::create('hoja_insumos_basicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_servicio_id')
                ->constrained('producto_servicios')
                ->onDelete('cascade');

            $table->foreignId('hoja_enfermeria_quirofano_id')
                ->constrained('hoja_enfermeria_quirofanos')
                ->onDelete('cascade');

            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_insumos_basicos');
    }
};
