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
        Schema::create('insumos', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('producto_servicios')
                ->onDelete('cascade');

            $table->string('categoria');
            $table->string('especificacion');
            $table->string('categoria_unitaria');
            $table->integer('cantidad_existente');
            $table->integer('cantidad_maxima')->nullable();
            $table->integer('cantidad_minima')->nullable();
            $table->string('proveedor')->nullable();
            $table->decimal('precio_compra')->nullable();
            $table->decimal('precio_venta'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
