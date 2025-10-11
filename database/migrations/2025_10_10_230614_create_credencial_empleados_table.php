  <?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration
  {
      public function up()
      {
          Schema::table('credencial_empleados', function (Blueprint $table) {
              // Agrega la columna si no existe
              if (!Schema::hasColumn('credencial_empleados', 'id_user')) {
                  $table->unsignedBigInteger('id_user')->after('id'); // Colócala después de id
                  $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
                  $table->index('id_user');
              }

              // Si falta cedula, agrégala (opcional)
              if (!Schema::hasColumn('credencial_empleados', 'cedula')) {
                  $table->string('cedula', 50)->nullable()->unique()->after('titulo');
              }
          });
      }

      public function down()
      {
          Schema::table('credencial_empleados', function (Blueprint $table) {
              $table->dropForeign(['id_user']); // Remueve foreign key primero
              $table->dropColumn('id_user');
              $table->dropColumn('cedula'); // Si la agregaste
          });
      }
  };
  