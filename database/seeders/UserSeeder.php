<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero, creamos los usuarios que no dependen de otros o que son sus propios responsables
        $userJuan = User::create([
            'curp' => 'JUAP850101HDFLRS01',
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'Ramírez',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1985-01-01',
            'email' => 'juan.perez@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        // Hacemos que Juan sea su propio responsable actualizando su registro
        $userJuan->colaborador_responsable_id = $userJuan->id;
        $userJuan->save();

        $userMaria = User::create([
            'curp' => 'MALO900214MDFLPS02',
            'nombre' => 'María',
            'apellido_paterno' => 'López',
            'apellido_materno' => 'Santos',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1990-02-14',
            'colaborador_responsable_id' => $userJuan->id, // Usamos el ID numérico de Juan
            'email' => 'maria.lopez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        $userCarlos = User::create([
            'curp' => 'CARA820710HDFRMR03',
            'nombre' => 'Carlos',
            'apellido_paterno' => 'Ramírez',
            'apellido_materno' => 'Moreno',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1982-07-10',
            'colaborador_responsable_id' => $userJuan->id, // Usamos el ID numérico de Juan
            'email' => 'carlos.ramirez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        // Ahora, creamos los usuarios que dependen de los que acabamos de crear
        User::create([
            'curp' => 'LAHE880320MDFHND04',
            'nombre' => 'Laura',
            'apellido_paterno' => 'Hernández',
            'apellido_materno' => 'Díaz',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1988-03-20',
            'colaborador_responsable_id' => $userCarlos->id, // Usamos el ID numérico de Carlos
            'email' => 'laura.hernandez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        $userAndres = User::create([
            'curp' => 'ANGG910923HDFGLZ05',
            'nombre' => 'Andrés',
            'apellido_paterno' => 'González',
            'apellido_materno' => 'Luna',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1991-09-23',
            'colaborador_responsable_id' => $userMaria->id, // Usamos el ID numérico de María
            'email' => 'andres.gonzalez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'curp' => 'SOMA950105MDFMRT06',
            'nombre' => 'Sofía',
            'apellido_paterno' => 'Martínez',
            'apellido_materno' => 'Rojas',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1995-01-05',
            'colaborador_responsable_id' => $userAndres->id, // Usamos el ID numérico de Andrés
            'email' => 'sofia.martinez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'curp' => 'TIMK040210HMSRDVA6',
            'nombre' => 'Kevin Yahir',
            'apellido_paterno' => 'Trinidad',
            'apellido_materno' => 'Medina',
            'sexo' => 'Masculino', // Corregido de 1 a 'Masculino'
            'fecha_nacimiento' => '2004-02-10',
            'email' => 'kevinyahirt@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
