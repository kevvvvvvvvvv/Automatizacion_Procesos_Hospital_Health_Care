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
        Schema::create('honorarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interconsulta_id')->constrained('interconsultas')->onDelete('cascade'); // Relación con interconsultas
            $table->decimal('monto', 10, 2); // Monto del honorario (ej: 150.00)
            $table->string('descripcion')->nullable(); // Descripción opcional (ej: "Consulta inicial")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('honorarios');
    }
};