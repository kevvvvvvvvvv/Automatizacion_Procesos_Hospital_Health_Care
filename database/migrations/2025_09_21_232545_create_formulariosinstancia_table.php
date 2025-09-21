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
        Schema::create('formulariosinstancia', function (Blueprint $table) {
            $table->bigIncrements('id_formulario_instancia');
            $table->datetime('fecha_hora');
            $table->unsignedBigInteger('id_estancia');
            $table->unsignedBigInteger('id_formulario_catalogo');
            $table->string('curpc',18);

            $table->foreign('id_estancia')
                ->references('id_estancia')
                ->on('estancias')
                ->onDelete('cascade');

            $table->foreign('id_formulario_catalogo')
                ->references('id_formulario_catalogo')
                ->on('formularioscatalogo')
                ->onDelete('cascade');

            $table->foreign('curpc')
                ->references('curpc')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulariosinstancia');
    }
};
