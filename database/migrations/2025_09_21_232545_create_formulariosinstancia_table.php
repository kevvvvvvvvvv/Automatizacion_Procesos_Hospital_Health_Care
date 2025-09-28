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

        Schema::create('formulario_instancias', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_hora');
            $table->foreignId('estancia_id')
                  ->constrained('estancias')
                  ->onDelete('cascade');

            $table->foreignId('formulario_catalogo_id')
                  ->constrained('formulario_catalogos') 
                  ->onDelete('cascade');


            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulario_instancias');
    }
};
