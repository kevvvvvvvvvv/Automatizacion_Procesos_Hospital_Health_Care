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
        Schema::create('histories', function (Blueprint $table) {
           $table->id();
            $table->foreignId('user_id')->nullable()->comment('El usuario que realizó la acción');
            $table->string('model_type')->comment('El modelo que fue afectado (ej: App\Models\Product)');
            $table->unsignedBigInteger('model_id')->comment('El ID del registro afectado');
            $table->string('action')->comment('La acción realizada (created, updated, deleted)');
            $table->json('before')->nullable()->comment('Estado del modelo antes del cambio');
            $table->json('after')->nullable()->comment('Estado del modelo después del cambio');
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
