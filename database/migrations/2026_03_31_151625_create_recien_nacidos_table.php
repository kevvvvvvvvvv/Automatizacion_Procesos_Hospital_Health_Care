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
    Schema::create('recien_nacidos', function (Blueprint $table) {
        // CORRECCIÓN: Nombre correcto del método y sin la S mayúscula inicial
        $table->unsignedBigInteger('id'); 
        $table->primary('id');
        
        $table->foreign('id')
            ->references('id')->on('formulario_instancias')
            ->onDelete('cascade');

        $table->string('area');
        $table->string('observaciones')->nullable();
        $table->string('nombre_rn');
        $table->string('sexo');
        $table->date('fecha_rn');
        $table->time('hora_rn');
        $table->float('peso'); // Para peso ej: 3.500
        
        // CORRECCIÓN: En Laravel el método es integer(), no int()
        $table->integer('talla'); 
        
        $table->string('estado');

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recien_nacidos');
    }
};
