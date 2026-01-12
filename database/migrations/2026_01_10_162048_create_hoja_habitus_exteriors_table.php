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
        Schema::create('hoja_habitus_exteriors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hoja_enfermeria_id')
                ->constrained('hoja_enfermerias')
                ->onDelete('cascade');

            $table->string('condicion_llegada');
            $table->string('facies');
            $table->string('constitucion');
            $table->string('postura');
            $table->string('piel');
            $table->string('estado_conciencia');
            $table->string('marcha');
            $table->string('movimientos');
            $table->string('higiene');
            $table->string('edad_aparente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_habitus_exteriors');
    }
};
