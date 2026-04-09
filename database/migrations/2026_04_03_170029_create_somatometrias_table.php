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
        Schema::create('somatometrias', function (Blueprint $table) {
            $table->id();

            // RELACIÓN: Apuntamos al ID de la tabla recien_nacidos
            // Usamos 'hoja_enfermeria_id' para mantener consistencia con tus otros formularios
            // o puedes usar 'recien_nacido_id'. Por consistencia con tus medicamentos:
            $table->foreignId('hoja_enfermeria_id')
                ->constrained('recien_nacidos') 
                ->onDelete('cascade');

            $table->float('perimetro_toracico')->nullable();
            $table->float('perimetro_cefalico')->nullable();
            $table->float('perimetro_abdominal')->nullable();
            $table->float('pie')->nullable();
            $table->float('segmento_inferior')->nullable();            
            $table->string('capurro')->nullable();
            $table->string('apgar')->nullable();
            $table->integer('silverman')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('somatometrias');
    }
};