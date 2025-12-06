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
        Schema::create('hoja_oxigenos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estancia_id')
                ->constrained('estancias')
                ->onDelete('cascade'); 
            
            $table->foreignId('user_id_inicio')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('user_id_fin')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->datetime('hora_inicio');
            $table->datetime('hora_fin')->nullable();
            $table->decimal('litros_minuto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_oxigenos');
    }
};
