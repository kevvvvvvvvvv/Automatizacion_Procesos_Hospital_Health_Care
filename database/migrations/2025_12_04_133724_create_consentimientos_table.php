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
        Schema::create('consentimientos', function (Blueprint $table) {
            $table->id();

            // FK a estancias
            $table->foreignId('estancia_id')->nullable()
                  ->constrained('estancias')
                  ->onDelete('cascade');

            $table->text('diagnostico')->nullable();

            // FK a users (tabla users)
            $table->foreignId('user_id')->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('route_pdf')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consentimientos');
    }
};
