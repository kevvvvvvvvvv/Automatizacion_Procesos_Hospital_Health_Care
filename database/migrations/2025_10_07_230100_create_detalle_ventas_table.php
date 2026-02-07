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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_producto_servicio')->nullable();
            $table->decimal('precio_unitario',8,2);
            $table->integer('cantidad');
            $table->decimal('subtotal',8,2);
            $table->decimal('descuento',8,2)->nullable();
            $table->string('estado');
            $table->decimal('iva_aplicado');

            $table->foreignId('venta_id')
                ->constrained('ventas')
                ->onDelete('cascade');

            $table->nullableMorphs('itemable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
