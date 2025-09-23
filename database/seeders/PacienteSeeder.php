<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Paciente::create([
                'nombre' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'telefono' => $faker->phoneNumber,
                'direccion' => $faker->address,
                'fecha_nacimiento' => $faker->date(),
            ]);
        }
    }
}
