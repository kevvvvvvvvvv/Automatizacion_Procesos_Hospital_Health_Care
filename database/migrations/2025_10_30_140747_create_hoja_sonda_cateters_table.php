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
        Schema::create('hoja_sonda_cateters', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_dispositivo');
            $table->string('calibre');
            $table->datetime('fecha_instalacion');
            $table->date('fecha_caducidad');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('observaciones')->nullable();
            $table->foreignId('estancia_id')
                ->constrained('estancias')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_sonda_cateters');
    }
};
