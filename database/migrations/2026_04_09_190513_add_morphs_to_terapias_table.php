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
            Schema::table('hoja_terapias', function (Blueprint $table) {
                $table->nullableMorphs('terapiable');
            });

            DB::table('hoja_terapias')->update([
                'terapiable_id' => DB::raw('hoja_enfermeria_id'),
                'terapiable_type' => 'App\Models\HojaEnfermeria',
            ]);

            Schema::table('hoja_terapias', function (Blueprint $table) {
                if (DB::getDriverName() !== 'sqlite'){
                    $table->dropColumn('hoja_enfermeria_id');
                } else {
                    $table->dropColumn('hoja_enfermeria_id');
                }
                $table->unsignedBigInteger('terapiable_id')->nullable(false)->change();
                $table->string('terapiable_type')->nullable(false)->change();
            });
        }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoja_terapias', function (Blueprint $table) {
            //
        });
    }
};
