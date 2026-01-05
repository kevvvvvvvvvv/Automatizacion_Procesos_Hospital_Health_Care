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
        Schema::create('hoja_sonda_cateters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_servicio_id')
                ->constrained('producto_servicios')
                ->onDelete('cascade');

            $table->datetime('fecha_instalacion')->nullable();
    
            $table->datetime('fecha_caducidad')->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('observaciones')->nullable();

            $table->foreignId('hoja_enfermeria_id')
                ->constrained('hoja_enfermerias')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_sonda_cateters');
    }
};
