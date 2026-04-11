<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
    Schema::table('hoja_registros', function (Blueprint $table) {
        $table->nullableMorphs('registrable');
    });

    DB::table('hoja_registros')->update([
        'registrable_id' => DB::raw('hoja_enfermeria_id'),
        'registrable_type' => 'App\Models\HojaEnfermeria',
    ]);

    Schema::table('hoja_registros', function (Blueprint $table) {
        if(DB::getDriverName() !== 'sqlite'){
            $table->dropColumn('hoja_enfermeria_id');
        } else {
            $table->dropColumn('hoja_enfermeria_id');
        }
        $table->unsignedBigInteger('registrable_id')->nullable(false)->change();
        $table->string('registrable_type')->nullable(false)->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            //
        });
    }
};
