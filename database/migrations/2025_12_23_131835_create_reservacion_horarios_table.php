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
        Schema::create('reservacion_horarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservacion_id')
                ->constrained('reservaciones')
                ->cascadeOnDelete();

            $table->foreignId('habitacion_precio_id')
                ->constrained('habitacion_precios')
                ->onDelete('cascade');

            $table->date('fecha');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservacion_horarios');
    }
};
