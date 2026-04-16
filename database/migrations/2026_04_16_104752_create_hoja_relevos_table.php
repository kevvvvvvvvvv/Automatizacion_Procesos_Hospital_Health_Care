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
        Schema::create('hoja_relevos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hoja_enfermeria_quirofano_id')
                ->constrained();
            $table->foreignId('user_id')
                ->constrained()
                ->comment('Enfermera que entra en el siguiente turno.');
            $table->dateTime('hora_entrada');
            $table->dateTime('hora_salida')->nullable();
            $table->text('observaciones_entrega')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_relevos');
    }
};
