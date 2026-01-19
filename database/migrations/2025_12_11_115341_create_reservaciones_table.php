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
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');

            $table->decimal('pago_total')->nullable();
            $table->enum('estatus', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            
            $table->string('stripe_payment_id')->nullable();

            $table->timestamps();
        });

    }
    
	
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservaciones');
    }
};
