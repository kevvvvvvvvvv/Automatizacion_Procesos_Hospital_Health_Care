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
            // 1. Clave primaria estándar
            $table->id();

            // 2. Clave foránea numérica que apunta a la tabla 'users'
            $table->foreignId('user_id')
                  ->unique() // Un usuario solo debe tener un registro de credenciales
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('titulo', 100);
            $table->string('cedula_profesional', 100);

            // 3. Timestamps para control de registros
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
