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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('total', 8, 2);
            $table->decimal('descuento', 8, 2)->nullable();
            $table->string('estado');
            //$table->string('descripcion');
            $table->foreignId('estancia_id')
                ->nullable()
                ->constrained('estancias')
                ->onDelete('set null'); 
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
