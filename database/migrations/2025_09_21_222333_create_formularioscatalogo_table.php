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
        Schema::create('formularioscatalogo', function (Blueprint $table) {
            $table->bigIncrements('id_formulario_catalogo');
            $table->string('nombre_formulario',100);
            $table->string('nombre_tabla_fisica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularioscatalogo');
    }
};
