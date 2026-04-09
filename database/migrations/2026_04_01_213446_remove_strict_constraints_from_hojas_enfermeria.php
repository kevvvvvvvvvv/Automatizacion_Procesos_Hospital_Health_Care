<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hoja_terapias', function (Blueprint $table) {
            $table->dropForeign(['hoja_enfermeria_id']);
        });

        Schema::table('hoja_registros', function (Blueprint $table) {
            $table->dropForeign(['hoja_enfermeria_id']);
        });

        Schema::table('hoja_medicamentos', function (Blueprint $table) {
            $table->dropForeign(['hoja_enfermeria_id']);
        });
    }

    public function down(): void
    {
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