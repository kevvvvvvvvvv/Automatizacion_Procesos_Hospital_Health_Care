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
    Schema::table('reservacion_quirofanos', function (Blueprint $table) {
        $table->enum('status', ['pendiente', 'completada', 'cancelada'])
              ->default('pendiente')
              ->after('localizacion');
        
        $table->text('motivo_cancelacion')->nullable()->after('status');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservacion_quirofanos', function (Blueprint $table) {
            $table->dropColumn(['status', 'motivo_cancelacion']);
        });
    }
};