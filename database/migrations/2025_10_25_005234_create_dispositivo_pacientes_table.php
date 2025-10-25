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
        Schema::create('dispositivo_pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estancia_id')
                  ->constrained('estancias')
                  ->onDelete('cascade');
            $table->string('tipo_dispositivo');
            $table->string('calibre')->nullable();
            $table->datetime('fecha_instalacion');
            $table->text('observaciones')->nullable();
            //$table->string('sitio_insercion')->nullable();
            //$table->datetime('fecha_retiro')->nullable();
            $table->foreignId('usuario_instalo_id')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            /*$table->foreignId('usuario_retiro_id')->nullable()
                  ->constrained('users')
                  ->onDelete('set null');*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositivo_pacientes');
    }
};
