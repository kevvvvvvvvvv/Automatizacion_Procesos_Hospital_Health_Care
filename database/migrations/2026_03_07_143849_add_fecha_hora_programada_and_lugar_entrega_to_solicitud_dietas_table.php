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
        Schema::table('solicitud_dietas', function (Blueprint $table) {
            $table->string('lugar_entrega')->nullable()->after('hoja_enfermeria_id');
            $table->datetime('fecha_hora_programada')->nullable()->after('hoja_enfermeria_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_dietas', function (Blueprint $table) {
            $table->dropColumn(['lugar_entrega','fecha_hora_programada']);
        });
    }
};
