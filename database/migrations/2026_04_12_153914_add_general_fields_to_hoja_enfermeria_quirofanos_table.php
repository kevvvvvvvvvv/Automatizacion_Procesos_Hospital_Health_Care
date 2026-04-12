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
        Schema::table('hoja_enfermeria_quirofanos', function (Blueprint $table) {
            $table->text('nota_enfermeria')->nullable();
            $table->string('posicion_paciente')->nullable();
            $table->text('procedimiento_quirurgico')->nullable();
            $table->string('placa_cauterio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoja_enfermeria_quirofanos', function (Blueprint $table) {
            $table->dropColumn('nota_enfermeria');
            $table->dropColumn('posicion_paciente');
            $table->dropColumn('procedimiento_quirurgico');
            $table->dropColumn('placa_cauterio');
        });
    }
};
