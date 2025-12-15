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

        $table->enum('localizacion', ['plan_ayutla', 'acapantzingo']);
        $table->date('fecha');

        // número total de bloques de 30 min
        $table->integer('horas');

        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

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
