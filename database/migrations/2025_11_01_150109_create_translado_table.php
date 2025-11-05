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
        Schema::create('translado', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('formulario_instancias')
                ->onDelete('cascade');
            $table->string('unidad_medica_envia')->nullable();
            $table->string('unidad_medica_recibe')->nullable();
            $table->text('motivo_translado')->nullable();
            $table->text('Resumen_clinico')->nullable();
            $table->string('ta')->nullable();
            $table->integer('fc')->nullable();
            $table->integer('fr')->nullable();
            $table->string('sat')->nullable();
            $table->decimal('temp', 5, 2)->nullable(); 
            $table->String('dxtx')->nullable();
            $table->string('tratamiento_terapeutico_administrada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translado');
    }
};
