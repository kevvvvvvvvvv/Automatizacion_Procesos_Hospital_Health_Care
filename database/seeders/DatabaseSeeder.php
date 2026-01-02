<?php

namespace Database\Seeders;

use App\Models\CatalogoPregunta;
use App\Models\FamiliarResponsable;
use App\Models\ProductoServicio;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            CargoSeeder::class,
            PacienteSeeder::class,
            HabitacionSeeder::class,
            FamiliarResponsableSeeder::class,
            RoleAndPermissionSeeder::class,
            FormularioCatalogoSeeder::class,
            ProductoServicioSeeder::class,
            CatalogoPreguntaSeeder::class,
            UserSeeder::class,
            EstanciaSeeder::class,
            CatalogoEstudioSeeder::class,
            HabitacionPrecioSeeder::class,
            CategoriaDietaSeeder::class,
            DietaSeeder::class,
        ]);

    }
}
