<?php
   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;
   use Illuminate\Support\Facades\DB;

   return new class extends Migration
   {
       public function up(): void
       {
           // Primero, drop la foreign key si existe
           Schema::table('credencial_empleados', function (Blueprint $table) {
               if (Schema::hasColumn('credencial_empleados', 'id_user')) {
                   $table->dropForeign('credencial_empleados_id_user_foreign');
               }
           });

           // Ahora, drop el campo
           Schema::table('credencial_empleados', function (Blueprint $table) {
               if (Schema::hasColumn('credencial_empleados', 'id_user')) {
                   $table->dropColumn('id_user');
               }
           });
       }

       public function down(): void
       {
           Schema::table('credencial_empleados', function (Blueprint $table) {
               $table->unsignedBigInteger('id_user')->nullable();
           });
       }
   };
   