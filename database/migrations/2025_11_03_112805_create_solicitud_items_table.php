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
        Schema::create('solicitud_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_estudio_id')
                  ->constrained('solicitud_estudios')
                  ->onDelete('cascade');

            $table->foreignId('catalogo_estudio_id') 
                  ->constrained('catalogo_estudios')
                  ->onDelete('cascade');
            
            $table->string('estado')->default('solicitado'); 
            
            $table->foreignId('user_realiza_id')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            
            $table->text('resultados')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_items');
    }
};
