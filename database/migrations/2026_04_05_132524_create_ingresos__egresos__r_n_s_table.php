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
        Schema::create('ingresos__egresos__r_n_s', function (Blueprint $table) {
            $table->id();

            // RELACIÓN: Conecta con el recién nacido
            $table->foreignId('hoja_enfermeria_id')
                ->constrained('recien_nacidos')
                ->onDelete('cascade');

            // INGRESOS
            $table->float('seno_materno')->nullable();
            $table->float('formula')->nullable();
            $table->string('otros_ingresos')->nullable(); 
            $table->float('cantidad_ingresos')->nullable();

            // EGRESOS
            $table->float('miccion')->nullable();
            $table->float('evacuacion')->nullable();
            $table->float('emesis')->nullable(); 
            $table->string('otros_egresos')->nullable(); 
            $table->float('cantidad_egresos')->nullable();
            // BALANCE TOTAL
            $table->float('balance_total')->nullable();

            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos__egresos__r_n_s');
    }
};
