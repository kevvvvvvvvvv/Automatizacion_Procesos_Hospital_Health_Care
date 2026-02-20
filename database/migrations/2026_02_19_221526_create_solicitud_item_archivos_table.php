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
        Schema::create('solicitud_item_archivos', function (Blueprint $table) {
            $table->id();
            $table->text('ruta_archivo_resultado')->nullable();
            $table->foreignId('solicitud_item_id')
                ->constrained('solicitud_items')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_item_archivos');
    }
};
