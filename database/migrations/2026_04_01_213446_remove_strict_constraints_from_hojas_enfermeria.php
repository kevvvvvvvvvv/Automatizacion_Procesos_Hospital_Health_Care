<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabla: hoja_terapias
        Schema::table('hoja_terapias', function (Blueprint $table) {
            // Usamos un array para que Laravel busque el nombre indexado de la llave
            $table->dropForeign(['hoja_enfermeria_id']);
        });

        // 2. Tabla: hoja_registros
        Schema::table('hoja_registros', function (Blueprint $table) {
            $table->dropForeign(['hoja_enfermeria_id']);
        });

        // 3. Tabla: hoja_medicamentos
        Schema::table('hoja_medicamentos', function (Blueprint $table) {
            $table->dropForeign(['hoja_enfermeria_id']);
        });
        
        // NOTA: Si tienes una tabla de 'aplicaciones_medicamentos', 
        // NO la toques, esa debe seguir apuntando a 'hoja_medicamentos'.
    }

    public function down(): void
    {
        // Esto es por si necesitas revertir, pero OJO: 
        // Solo funcionará si NO has insertado datos de Recién Nacidos aún.
        Schema::table('hoja_terapias', function (Blueprint $table) {
            $table->foreign('hoja_enfermeria_id')
                  ->references('id')->on('hoja_enfermerias')
                  ->onDelete('cascade');
        });

        Schema::table('hoja_registros', function (Blueprint $table) {
            $table->foreign('hoja_enfermeria_id')
                  ->references('id')->on('hoja_enfermerias')
                  ->onDelete('cascade');
        });

        Schema::table('hoja_medicamentos', function (Blueprint $table) {
            $table->foreign('hoja_enfermeria_id')
                  ->references('id')->on('hoja_enfermerias')
                  ->onDelete('cascade');
        });
    }
};