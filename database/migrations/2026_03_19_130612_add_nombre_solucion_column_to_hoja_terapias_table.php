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
        Schema::table('hoja_terapias', function (Blueprint $table) {
            $table->string('nombre_solucion')->after('solucion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoja_terapias', function (Blueprint $table) {
            $table->dropColumn('nombre_solucion');
        });
    }
};
