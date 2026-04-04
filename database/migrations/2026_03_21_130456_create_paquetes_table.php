<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration 
{
    public function up(): void
    {
       Schema::create('paquetes', function (Blueprint $table) {
    $table->id(); 
    $table->foreignId('formulario_instancia_id')->constrained('formulario_instancias')->onDelete('cascade');
    $table->foreignId('solicitud_estudio_id')->constrained('solicitud_estudios')->onDelete('cascade');

    // Datos del estudio
    $table->foreignId('catalogo_estudio_id')->nullable()->constrained('catalogo_estudios');
    $table->string('otro_estudio')->nullable();
    $table->string('departamento_destino');

    // --- CAMPOS DE SIGNOS VITALES (NUEVOS) ---
    $table->string('ta_sistolica')->nullable();
    $table->string('ta_diastolica')->nullable();
    $table->string('fc')->nullable();
    $table->string('fr')->nullable();
    $table->string('temp')->nullable();
    $table->string('so2')->nullable();
    $table->string('glucemia')->nullable();
    $table->string('peso')->nullable();
    $table->string('talla')->nullable();

    $table->string('estado')->default('SOLICITADO'); 
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};