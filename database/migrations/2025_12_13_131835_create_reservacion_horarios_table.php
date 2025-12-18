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
            $table->dateTime('fecha_hora');

            $table->timestamps();
            $table->unique(['reservacion_id', 'fecha_hora']);
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
