<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        Paciente::create([
            'curp' => 'MARP850101HDFLRS01',
            'nombre' => 'María',
            'apellido_paterno' => 'Ramírez',
            'apellido_materno' => 'López',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1985-01-01',
            'calle' => 'Av. Reforma',
            'numero_exterior' => '123',
            'numero_interior' => '2B',
            'colonia' => 'Centro',
            'municipio' => 'Cuauhtémoc',
            'estado' => 'Ciudad de México',
            'pais' => 'México',
            'cp' => '06000',
            'telefono' => '555-111-2233',
            'estado_civil' => 'Casado(a)',
            'ocupacion' => 'Contadora',
            'lugar_origen' => 'Ciudad de México',
            'nombre_padre' => 'Juan Ramírez',
            'nombre_madre' => 'Elena López',
        ]);

        Paciente::create([
            'curp' => 'LOPE900305HDFGNS02',
            'nombre' => 'José',
            'apellido_paterno' => 'López',
            'apellido_materno' => 'González',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1990-03-05',
            'calle' => 'Calle Insurgentes',
            'numero_exterior' => '456',
            'numero_interior' => null,
            'colonia' => 'Roma Norte',
            'municipio' => 'Cuauhtémoc',
            'estado' => 'Ciudad de México',
            'pais' => 'México',
            'cp' => '06700',
            'telefono' => '555-222-3344',
            'estado_civil' => 'Soltero(a)',
            'ocupacion' => 'Ingeniero',
            'lugar_origen' => 'Puebla',
            'nombre_padre' => 'Carlos López',
            'nombre_madre' => 'María González',
        ]);

        Paciente::create([
            'curp' => 'FERL750712MMNGRZ03',
            'nombre' => 'Lucía',
            'apellido_paterno' => 'Fernández',
            'apellido_materno' => 'Martínez',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1975-07-12',
            'calle' => 'Av. Morelos',
            'numero_exterior' => '789',
            'numero_interior' => '5A',
            'colonia' => 'Chapultepec',
            'municipio' => 'Morelia',
            'estado' => 'Michoacán',
            'pais' => 'México',
            'cp' => '58000',
            'telefono' => '555-333-4455',
            'estado_civil' => 'Divorciado(a)',
            'ocupacion' => 'Maestra',
            'lugar_origen' => 'Morelia',
            'nombre_padre' => 'Rafael Fernández',
            'nombre_madre' => 'Laura Martínez',
        ]);

        Paciente::create([
            'curp' => 'GOME820914HGTPLD04',
            'nombre' => 'Pedro',
            'apellido_paterno' => 'Gómez',
            'apellido_materno' => 'Paredes',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1982-09-14',
            'calle' => 'Av. Hidalgo',
            'numero_exterior' => '101',
            'numero_interior' => null,
            'colonia' => 'Centro',
            'municipio' => 'Guadalajara',
            'estado' => 'Jalisco',
            'pais' => 'México',
            'cp' => '44100',
            'telefono' => '555-444-5566',
            'estado_civil' => 'Union libre',
            'ocupacion' => 'Mecánico',
            'lugar_origen' => 'Guadalajara',
            'nombre_padre' => 'Manuel Gómez',
            'nombre_madre' => 'Isabel Paredes',
        ]);

        Paciente::create([
            'curp' => 'RUIE950221HNLTRS05',
            'nombre' => 'Elena',
            'apellido_paterno' => 'Ruiz',
            'apellido_materno' => 'Treviño',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1995-02-21',
            'calle' => 'Calle Juárez',
            'numero_exterior' => '567',
            'numero_interior' => '3C',
            'colonia' => 'Obrera',
            'municipio' => 'Monterrey',
            'estado' => 'Nuevo León',
            'pais' => 'México',
            'cp' => '64000',
            'telefono' => '555-555-6677',
            'estado_civil' => 'Soltero(a)',
            'ocupacion' => 'Diseñadora',
            'lugar_origen' => 'Monterrey',
            'nombre_padre' => 'Héctor Ruiz',
            'nombre_madre' => 'Marta Treviño',
        ]);

        Paciente::create([
            'curp' => 'SANM700811HOCGRD06',
            'nombre' => 'Miguel',
            'apellido_paterno' => 'Sánchez',
            'apellido_materno' => 'Morales',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1970-08-11',
            'calle' => 'Av. Independencia',
            'numero_exterior' => '890',
            'numero_interior' => null,
            'colonia' => 'Centro',
            'municipio' => 'Oaxaca de Juárez',
            'estado' => 'Oaxaca',
            'pais' => 'México',
            'cp' => '68000',
            'telefono' => '555-666-7788',
            'estado_civil' => 'Viudo(a)',
            'ocupacion' => 'Carpintero',
            'lugar_origen' => 'Oaxaca',
            'nombre_padre' => 'Domingo Sánchez',
            'nombre_madre' => 'Juana Morales',
        ]);
    }
}
