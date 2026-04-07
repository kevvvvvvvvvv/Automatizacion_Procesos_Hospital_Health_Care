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
        Schema::create('sesion_cajas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('caja_id')
                ->constrained('cajas')
                ->comment('Caja física donde se realiza el turno');
            
            $table->foreignId('user_id')
                ->constrained('users')
                ->comment('Cajero responsable del turno');
            
            $table->timestamp('fecha_apertura')
                ->useCurrent()
                ->comment('Fecha y hora exacta en la que el cajero abrió el turno');
            
            $table->timestamp('fecha_cierre')
                ->nullable()
                ->comment('Fecha y hora del corte de caja');
            
            $table->decimal('monto_inicial', 10, 2)
                ->comment('Fondo de caja (dinero base para dar cambio al iniciar)');
                
            $table->string('estado')
                ->default('abierta')
                ->comment('Estado operativo de la sesión');
            
            // Totales calculados
            $table->decimal('total_ingresos_efectivo', 10, 2)
                ->default(0)
                ->comment('Suma de ventas y otros ingresos en efectivo');
            
            $table->decimal('total_egresos_efectivo', 10, 2)
                ->default(0)
                ->comment('Suma de retiros y pagos en efectivo');
            
            $table->decimal('total_otros_metodos', 10, 2)
                ->default(0)
                ->comment('Suma de pagos con tarjeta, transferencia, etc.');
            
            // Datos de auditoría al cerrar
            $table->decimal('monto_declarado', 10, 2)
                ->nullable()
                ->comment('Dinero físico total contado por el cajero al hacer el corte');
            
            $table->decimal('sobrante_faltante', 10, 2)
                ->nullable()
                ->comment('Diferencia matemática: Declarado - (Inicial + Ingresos - Egresos)');   
                         
            $table->decimal('monto_enviado_contaduria')
                ->nullable()
                ->comment('El monto que se retira de caja para enviar a contaduria.');

            $table->boolean('auditada')->default(false);
            $table->decimal('monto_ajuste', 10, 2)->default(0); // Por si el contador recupera dinero
            $table->text('observacion_auditoria')->nullable(); // El "por qué" del ajuste
            $table->foreignId('auditor_id')->nullable()->constrained('users'); // Quién lo hizo
            $table->timestamp('fecha_auditoria')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion_cajas');
    }
};
