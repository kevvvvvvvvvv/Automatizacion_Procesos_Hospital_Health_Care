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
        Schema::create('movimiento_cajas', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('sesion_caja_id')
                ->constrained('sesion_cajas')
                ->cascadeOnDelete()
                ->comment('Turno al que pertenece este movimiento');
            
            $table->string('tipo')
                ->comment('Indica si el dinero entró o salió de la caja física (ingreso o egreso)');
            
            $table->decimal('monto', 10, 2)
                ->comment('Cantidad de dinero del movimiento');

            $table->string('concepto')
                ->comment('Motivo (ej. Pago de garrafones, Retiro de exceso de efectivo)');
            
            $table->string('comprobante')
                ->nullable()
                ->comment('Ruta al archivo o foto del ticket de respaldo');
            
            $table->foreignId('user_id')
                ->constrained('users')
                ->comment('Usuario que registró o autorizó el movimiento');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_cajas');
    }
};
