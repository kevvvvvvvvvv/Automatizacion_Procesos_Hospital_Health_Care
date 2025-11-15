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
        Schema::create('transfusion_realizadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_postoperatoria_id')
                ->constrained('nota_postoperatorias')
                ->onDelete('cascade');
            $table->string('tipo_transfusion');
            $table->string('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfusion_realizadas');
    }
};
