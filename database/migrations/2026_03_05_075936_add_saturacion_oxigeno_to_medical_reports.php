<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $tables = ['nota_postoperatorias', 'preoperatorios', 'notas_evoluciones', 'nota_pre_anestesicas', 'nota_postanestesicas', 'traslado'];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedTinyInteger('spo2')
                      ->nullable()
                      ->comment('Saturación de oxígeno en porcentaje (0-100)')
                      ->after('fr');    
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('spo2');
            });
        }
    }
};
