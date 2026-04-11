<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    // 1. Crear las columnas nuevas
        Schema::table('hoja_medicamentos', function (Blueprint $table) {
            $table->nullableMorphs('medicable');
        });

        // 2. Mover datos (Asegúrate de importar use Illuminate\Support\Facades\DB;)
        DB::table('hoja_medicamentos')->update([
            'medicable_id' => DB::raw('hoja_enfermeria_id'),
            'medicable_type' => 'App\Models\Formulario\HojaEnfermeria\HojaEnfermeria', // ¡Ojo! Usa el namespace completo de tu modelo
        ]);

        // 3. Borrar la columna vieja de forma segura
        Schema::table('hoja_medicamentos', function (Blueprint $table) {
            // En lugar de dropForeign(['hoja_enfermeria_id']), usamos esto:
            if (DB::getDriverName() !== 'sqlite') {
                // Esto intenta borrar la relación solo si existe, 
                // pero lo más seguro para que no falle es borrar la columna directo
                $table->dropColumn('hoja_enfermeria_id'); 
            } else {
                $table->dropColumn('hoja_enfermeria_id');
            }

            // 4. Hacer los campos obligatorios
            $table->unsignedBigInteger('medicable_id')->nullable(false)->change();
            $table->string('medicable_type')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hojas_medicamentos', function (Blueprint $table) {
            //
        });
    }
};
