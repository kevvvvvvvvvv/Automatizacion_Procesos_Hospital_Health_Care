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
Schema::create('solicitud_traspasos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('caja_origen_id')
                ->constrained('cajas')
                ->comment('De donde sale el dinero (ej. Contaduría o Bóveda)');
            
            $table->foreignId('caja_destino_id')
                ->constrained('cajas')
                ->comment('A dónde va el dinero (ej. El Fondo)');
            
            $table->decimal('monto_solicitado', 10, 2)
                ->comment('Lo que el sistema o el usuario pide originalmente');
            
            $table->decimal('monto_aprobado', 10, 2)
                ->nullable()
                ->comment('Lo que Contaduría decide enviar realmente (puede ser diferente al solicitado)');
            
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])
                ->default('pendiente')
                ->comment('Estado actual de la solicitud de traspaso');
            
            $table->string('concepto')
                ->comment('El concepto para el historial (ej. Reposición automática por retiro de Urgencias)');

            $table->foreignId('user_solicita_id')
                ->constrained('users')
                ->comment('Usuario/Cajero que detonó o creó la solicitud');
            
            $table->foreignId('user_aprueba_id')
                ->nullable()
                ->constrained('users')
                ->comment('Usuario de Contaduría que autorizó o rechazó el movimiento');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_traspasos');
    }
};
