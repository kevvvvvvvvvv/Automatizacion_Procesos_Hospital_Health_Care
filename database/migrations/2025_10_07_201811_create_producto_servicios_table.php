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
        Schema::create('producto_servicios', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('tipo');
            $table->string('subtipo');
            $table->string('codigo_prestacion')->nullable();
            $table->string('codigo_barras')->nullable()->index();
            $table->string('nombre_prestacion',200);

            $table->decimal('importe', 8, 2)->default(0.1); 
            $table->decimal('importe_compra')->nullable();

            $table->integer('cantidad')->nullable();
            $table->integer('cantidad_maxima')->nullable();
            $table->integer('cantidad_minima')->nullable();

            $table->string('proveedor')->nullable();

            $table->decimal('iva',8,2)->default(16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_servicios');
    }
};
