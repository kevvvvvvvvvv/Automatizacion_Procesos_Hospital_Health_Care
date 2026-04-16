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
        Schema::create('egreso_liquidos', function (Blueprint $table) {
            $table->id();
            $table->morphs('liquidable'); 
            $table->string('tipo')
                ->comment('uresis, diuresis, etc'); 
            $table->float('cantidad')
                ->comment('ml'); 
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egreso_liquidos');
    }
};
