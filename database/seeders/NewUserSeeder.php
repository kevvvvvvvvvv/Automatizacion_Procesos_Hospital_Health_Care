<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $medicos = [
            ['nombre' => 'Ricardo Herrera', 'sexo' => 'Masculino', 'telefono' => '7771884903'],
            ['nombre' => 'Erik Brito', 'sexo' => 'Masculino', 'telefono' => '7774948044'],
            ['nombre' => 'Cesar Bahena', 'sexo' => 'Masculino', 'telefono' => '7773701041'],
            ['nombre' => 'Fernando Gonzalez Acosta', 'sexo' => 'Masculino', 'telefono' => '7771293854'],
            ['nombre' => 'Rommel Flores Valencia', 'sexo' => 'Masculino', 'telefono' => '5522727139'],
            ['nombre' => 'Jose Luis Romero Manzanarez', 'sexo' => 'Masculino', 'telefono' => '5539678685'],
            ['nombre' => 'Manuel Hiromoto', 'sexo' => 'Masculino', 'telefono' => '7775632147'],
            ['nombre' => 'Oscar Manuel Barcenas', 'sexo' => 'Masculino', 'telefono' => '7331013447'],
            ['nombre' => 'Aguilar Garibai', 'sexo' => 'Masculino', 'telefono' => '5542735289'],
            ['nombre' => 'Carrillo', 'sexo' => 'Masculino', 'telefono' => '7773057239'],
            ['nombre' => 'Mario Alcantara', 'sexo' => 'Masculino', 'telefono' => '7776600044'],
            ['nombre' => 'David Garcia', 'sexo' => 'Masculino', 'telefono' => '7772400665'],
            ['nombre' => 'Zeus Jarillo Vergara', 'sexo' => 'Masculino', 'telefono' => '7773888649'],
            ['nombre' => 'Cuevas', 'sexo' => 'Masculino', 'telefono' => '7771350130'],
            ['nombre' => 'Jorge Salmeron', 'sexo' => 'Masculino', 'telefono' => '7772193596'],
            ['nombre' => 'Alejandro Gill', 'sexo' => 'Masculino', 'telefono' => '7772496815'],
            ['nombre' => 'Bustillos', 'sexo' => 'Masculino', 'telefono' => '7771932368'],
            ['nombre' => 'William', 'sexo' => 'Masculino', 'telefono' => '7352806750'],
            ['nombre' => 'Chinchilla', 'sexo' => 'Masculino', 'telefono' => '7772101043'],
            ['nombre' => 'Urbina', 'sexo' => 'Masculino', 'telefono' => '7773282755'],
            ['nombre' => 'Raul Sandoval', 'sexo' => 'Masculino', 'telefono' => '7771628024'],
            ['nombre' => 'Rafael Enrique Rosales Hernandez', 'sexo' => 'Masculino', 'telefono' => '4424360305'],
            ['nombre' => 'Erik Ivan Montes Sales', 'sexo' => 'Masculino', 'telefono' => '7772190840'],
            ['nombre' => 'Alejandro Alonso Najera', 'sexo' => 'Masculino', 'telefono' => '7771415403'],
            ['nombre' => 'Cesar Rodriguez Millan', 'sexo' => 'Masculino', 'telefono' => '7775114091'],
            ['nombre' => 'Perez Chavez', 'sexo' => 'Masculino', 'telefono' => '7771135289'],
            ['nombre' => 'Jorge Eduardo Aguilar Garibay', 'sexo' => 'Masculino', 'telefono' => '7772879201'],
            ['nombre' => 'Jose Cuauhtemoc Magadan Salazar', 'sexo' => 'Masculino', 'telefono' => '7773272550'],
            ['nombre' => 'Miguel Angel Rocha Correa', 'sexo' => 'Masculino', 'telefono' => '7771844588'],
            ['nombre' => 'Uriel Francisco Blanco Perez', 'sexo' => 'Masculino', 'telefono' => '7771119231'],
        ];

        foreach ($medicos as $data) {
            $partes = explode(' ', trim($data['nombre']));
            
            if (count($partes) > 1) {
                $emailPrefix = Str::slug($partes[0]) . '.' . Str::slug($partes[1]);
            } else {
                $emailPrefix = Str::slug($partes[0]);
            }

            User::create([
                'nombre'   => $data['nombre'],
                'sexo'     => $data['sexo'],
                'email'    => $emailPrefix . '@test.com',
                'telefono' => $data['telefono'],
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
