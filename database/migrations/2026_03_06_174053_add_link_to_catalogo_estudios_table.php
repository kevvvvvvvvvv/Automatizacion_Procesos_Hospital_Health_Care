<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catalogo_estudios', function (Blueprint $table) {
            // Agregamos el campo después de 'tiempo_entrega' (o el que prefieras)
            $table->text('link')->nullable()->after('tiempo_entrega');
        });
    }

    public function down(): void
    {
        Schema::table('catalogo_estudios', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};