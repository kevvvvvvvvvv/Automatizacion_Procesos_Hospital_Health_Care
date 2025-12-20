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
    Schema::create('reservacion_quirofanos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('habitacion_id')->constrained('habitaciones')->cascadeOnDelete();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('estancia_id')->constrained('estancias')->cascadeOnDelete();

        $table->string('procedimiento');
        $table->string('tiempo_estimado');
        $table->string('medico_operacion');
        
        
        // Almacenamos el detalle. Si es NULL, se entiende que marcaron "No".
        $table->text('instrumentista');
        $table->text('anestesiologo');
        $table->text('insumos_medicamentos')->nullable();
        $table->text('esterilizar_detalle')->nullable();
        $table->text('rayosx_detalle')->nullable();
        $table->text('patologico_detalle')->nullable();
        $table->text('comentarios')->nullable();

        $table->json('horarios'); // Guardamos el array de horas seleccionadas
        $table->date('fecha');
        $table->string('localizacion');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservacion_quirofanos');
    }
};
