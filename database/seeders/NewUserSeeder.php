<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userEmmanuel = User::firstOrCreate(
            ['email' => 'emmanuel.robles@test.com'], 
            [
                'curp' => 'RORE850615HDFRRN06', 
                'nombre' => 'Emmanuel',         
                'apellido_paterno' => 'Robles',
                'apellido_materno' => 'Rosas',
                'sexo' => 'Masculino',
                'fecha_nacimiento' => '1985-06-15', 
                'telefono' => '7775558899',     
                'password' => Hash::make('12345678'),
            ]
        );

        $userEmmanuel->assignRole('medico');
    }
}
