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
        Schema::create('credencial_empleados', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')
                  ->unique() 
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('titulo', 100);
            $table->string('cedula_profesional', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credencial_empleados');
    }
};
