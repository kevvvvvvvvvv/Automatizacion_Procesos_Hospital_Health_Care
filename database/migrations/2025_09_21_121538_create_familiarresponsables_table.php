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
        Schema::create('familiar_responsables', function (Blueprint $table) {
            $table->id();
            $table->string('parentesco');
            $table->string('nombre_completo');
            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familiar_responsables');
    }
};
