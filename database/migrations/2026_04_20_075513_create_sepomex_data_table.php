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
        Schema::create('sepomex_data', function (Blueprint $table) {
            $table->id();
            
            $table->string('d_codigo', 5)->index(); 
            $table->string('d_asenta');           // Colonia
            $table->string('d_tipo_asenta');      // Tipo de asentamiento
            $table->string('D_mnpio');            // Municipio
            $table->string('d_estado');           // Estado
            $table->string('d_ciudad')->nullable();
            $table->string('c_estado', 10);       // Clave de estado 
            $table->string('c_mnpio', 10);        // Clave de municipio
            
            $table->unique(['d_codigo', 'd_asenta', 'D_mnpio'], 'sepomex_unique_index');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sepomex_data');
    }
};
