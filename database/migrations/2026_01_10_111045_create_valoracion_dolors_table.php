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
        Schema::create('valoracion_dolors', function (Blueprint $table) {
            $table->id();

            $table->integer('escala_eva');
            $table->string('ubicacion_dolor');
            $table->foreignId('hoja_escala_valoracion_id')
                ->constrained('hoja_escala_valoracions')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoracion_dolors');
    }
};
