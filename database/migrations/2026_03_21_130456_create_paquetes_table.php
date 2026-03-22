<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');
            $table->foreignId('solicitud_estudio_id')
                ->constrained('solicitud_estudios')
                ->onDelete('cascade');
            $table->foreignId('catalogo_estudio_id')
                ->nullable()
                ->constrained('catalogo_estudios');
            $table->string('otro_estudio')->nullable();
            $table->string('departamento_destino');
            $table->string('estado')->default('SOLICITADO'); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};