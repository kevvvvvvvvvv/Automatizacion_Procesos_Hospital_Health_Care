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
        Schema::create('desglose_efectivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_caja_id')
                ->constrained('sesion_cajas')
                ->cascadeOnDelete()
                ->comment('Sesión de caja a la que pertenece este conteo');
            
            $table->decimal('denominacion', 8, 2)
                ->comment('Valor facial de la moneda o billete (ej. 500.00, 20.00, 0.50)');
            
            $table->integer('cantidad')
                ->comment('Cantidad de piezas físicas de esta denominación');
            
            $table->decimal('total', 10, 2)
                ->comment('Resultado automático de: denominacion * cantidad');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desglose_efectivos');
    }
};
