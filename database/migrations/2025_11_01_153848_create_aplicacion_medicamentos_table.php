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
        Schema::create('aplicacion_medicamentos', function (Blueprint $table) {
            $table->id();

        $table->foreignId('hoja_medicamento_id')
              ->constrained('hoja_medicamentos') 
              ->onDelete('cascade'); 

        $table->dateTime('fecha_aplicacion');

        $table->foreignId('user_id')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplicacion_medicamentos');
    }
};
