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
            $table->decimal('monto_ingresado', 10, 2)->nullable()->after('monto');
            $table->decimal('cambio_dispensado', 10, 2)->nullable()->after('monto_ingresado');
            $table->string('clave_cajero')->nullable()->after('referencia');
            $table->json('metadata_cajero')->nullable()->after('clave_cajero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn([
                'monto_ingresado', 
                'cambio_dispensado', 
                'clave_cajero', 
                'metadata_cajero'
            ]);
        });
    }
};
