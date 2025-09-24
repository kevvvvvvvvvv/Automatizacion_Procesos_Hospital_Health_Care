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
    Paciente::create([
        'curpp' => 'MARP850101HDFLRS01',
        'nombre' => 'María',
        'apellidop' => 'Ramírez',
        'apellidom' => 'López',
        'sexo' => 'Femenino',
        'fechaNacimiento' => '1985-01-01',
        'calle' => 'Av. Reforma',
        'numeroExterior' => '123',
        'numeroInterior' => '2B',
        'colonia' => 'Centro',
        'municipio' => 'Cuauhtémoc',
        'estado' => 'Ciudad de México',
        'pais' => 'México',
        'cp' => '06000',
        'telefono' => '555-111-2233',
        'estadoCivil' => 'casado(a)',
        'ocupacion' => 'Contadora',
        'lugarOrigen' => 'Ciudad de México',
        'nombrePadre' => 'Juan Ramírez',
        'nombreMadre' => 'Elena López',
    ]);

    Paciente::create([
        'curpp' => 'LOPE900305HDFGNS02',
        'nombre' => 'José',
        'apellidop' => 'López',
        'apellidom' => 'González',
        'sexo' => 'Masculino',
        'fechaNacimiento' => '1990-03-05',
        'calle' => 'Calle Insurgentes',
        'numeroExterior' => '456',
        'numeroInterior' => null,
        'colonia' => 'Roma Norte',
        'municipio' => 'Cuauhtémoc',
        'estado' => 'Ciudad de México',
        'pais' => 'México',
        'cp' => '06700',
        'telefono' => '555-222-3344',
        'estadoCivil' => 'soltero(a)',
        'ocupacion' => 'Ingeniero',
        'lugarOrigen' => 'Puebla',
        'nombrePadre' => 'Carlos López',
        'nombreMadre' => 'María González',
    ]);

    Paciente::create([
        'curpp' => 'FERL750712MMNGRZ03',
        'nombre' => 'Lucía',
        'apellidop' => 'Fernández',
        'apellidom' => 'Martínez',
        'sexo' => 'Femenino',
        'fechaNacimiento' => '1975-07-12',
        'calle' => 'Av. Morelos',
        'numeroExterior' => '789',
        'numeroInterior' => '5A',
        'colonia' => 'Chapultepec',
        'municipio' => 'Morelia',
        'estado' => 'Michoacán',
        'pais' => 'México',
        'cp' => '58000',
        'telefono' => '555-333-4455',
        'estadoCivil' => 'divorciado(a)',
        'ocupacion' => 'Maestra',
        'lugarOrigen' => 'Morelia',
        'nombrePadre' => 'Rafael Fernández',
        'nombreMadre' => 'Laura Martínez',
    ]);

    Paciente::create([
        'curpp' => 'GOME820914HGTPLD04',
        'nombre' => 'Pedro',
        'apellidop' => 'Gómez',
        'apellidom' => 'Paredes',
        'sexo' => 'Masculino',
        'fechaNacimiento' => '1982-09-14',
        'calle' => 'Av. Hidalgo',
        'numeroExterior' => '101',
        'numeroInterior' => null,
        'colonia' => 'Centro',
        'municipio' => 'Guadalajara',
        'estado' => 'Jalisco',
        'pais' => 'México',
        'cp' => '44100',
        'telefono' => '555-444-5566',
        'estadoCivil' => 'union_libre',
        'ocupacion' => 'Mecánico',
        'lugarOrigen' => 'Guadalajara',
        'nombrePadre' => 'Manuel Gómez',
        'nombreMadre' => 'Isabel Paredes',
    ]);

    Paciente::create([
        'curpp' => 'RUIE950221HNLTRS05',
        'nombre' => 'Elena',
        'apellidop' => 'Ruiz',
        'apellidom' => 'Treviño',
        'sexo' => 'Femenino',
        'fechaNacimiento' => '1995-02-21',
        'calle' => 'Calle Juárez',
        'numeroExterior' => '567',
        'numeroInterior' => '3C',
        'colonia' => 'Obrera',
        'municipio' => 'Monterrey',
        'estado' => 'Nuevo León',
        'pais' => 'México',
        'cp' => '64000',
        'telefono' => '555-555-6677',
        'estadoCivil' => 'soltero(a)',
        'ocupacion' => 'Diseñadora',
        'lugarOrigen' => 'Monterrey',
        'nombrePadre' => 'Héctor Ruiz',
        'nombreMadre' => 'Marta Treviño',
    ]);

    Paciente::create([
        'curpp' => 'SANM700811HOCGRD06',
        'nombre' => 'Miguel',
        'apellidop' => 'Sánchez',
        'apellidom' => 'Morales',
        'sexo' => 'Masculino',
        'fechaNacimiento' => '1970-08-11',
        'calle' => 'Av. Independencia',
        'numeroExterior' => '890',
        'numeroInterior' => null,
        'colonia' => 'Centro',
        'municipio' => 'Oaxaca de Juárez',
        'estado' => 'Oaxaca',
        'pais' => 'México',
        'cp' => '68000',
        'telefono' => '555-666-7788',
        'estadoCivil' => 'viudo(a)',
        'ocupacion' => 'Carpintero',
        'lugarOrigen' => 'Oaxaca',
        'nombrePadre' => 'Domingo Sánchez',
        'nombreMadre' => 'Juana Morales',
    ]);

    }
}
