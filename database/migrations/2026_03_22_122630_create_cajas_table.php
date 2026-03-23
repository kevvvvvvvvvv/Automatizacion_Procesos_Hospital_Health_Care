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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')
                ->comment('Nombre o ubicación de la caja (ej. Caja Principal, Farmacia)');

            $table->boolean('activa')
                ->default(true)
                ->comment('Indica si la caja está habilitada para ser usada');
                
            $table->string('tipo')
                ->default('operativa')
                ->comment('operativa, fondo, boveda');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
