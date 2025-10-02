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
        Schema::create('hoja_frontales', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')
                ->references('id')->on('formulario_instancias')
                ->onDelete('cascade'); 

            $table->foreignId('medico_id')
                ->constrained('users')
                ->onDelete('cascade');
                
            $table->string('responsable');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_frontales');
    }
};
