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
        Schema::table('pagos', function (Blueprint $table) {
            $table->foreignId('sesion_caja_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('sesion_cajas')
                  ->nullOnDelete()
                  ->comment('Turno de caja en el que se recibió este pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropForeign(['sesion_caja_id']);
            $table->dropColumn('sesion_caja_id');
        });
    }
};
