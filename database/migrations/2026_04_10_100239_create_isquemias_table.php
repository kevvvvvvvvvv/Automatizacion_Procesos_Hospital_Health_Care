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
        Schema::create('isquemias', function (Blueprint $table) {
            $table->id();
            $table->morphs('isquemiable');
            $table->string('sitio_anatomico');
            $table->dateTime('hora_inicio')->nullable();
            $table->dateTime('hora_termino')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isquemias');
    }
};
