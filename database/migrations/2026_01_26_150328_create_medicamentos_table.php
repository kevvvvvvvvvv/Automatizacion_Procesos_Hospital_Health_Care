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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')
                ->on('producto_servicios')
                ->onDelete('cascade');

            $table->text('excipiente_activo_gramaje');
            $table->decimal('volument_total');
            $table->string('nombre_comercial');
            $table->string('gramaje');
            $table->boolean('fraccion');
            $table->date('fecha_caducidad')->nullable();
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
        Schema::dropIfExists('medicamentos');
    }
};
