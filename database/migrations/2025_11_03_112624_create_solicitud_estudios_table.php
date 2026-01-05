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
        Schema::create('solicitud_estudios', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');

            $table->foreignId('user_solicita_id') 
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->foreignId('user_llena_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            $table->text('problemas_clinicos')->nullable(); 
            $table->text('incidentes_accidentes')->nullable();
            $table->text('resultado')->nullable();

            $table->nullableMorphs('itemable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_estudios');
    }
};
