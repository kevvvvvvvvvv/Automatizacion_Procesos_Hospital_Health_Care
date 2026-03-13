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
        // Usamos boolean, que en MySQL se traduce a TINYINT(1) (0 o 1)
        $table->boolean('requiere_factura')->default(0)->after('metodo_pago_id');
    });
}

public function down(): void
{
    Schema::table('pagos', function (Blueprint $table) {
        $table->dropColumn('requiere_factura');
    });
}
};
