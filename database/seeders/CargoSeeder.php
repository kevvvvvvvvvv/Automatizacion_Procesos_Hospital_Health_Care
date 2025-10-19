<?php

namespace Database\Seeders;

use App\Models\Cargo; 
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            ['nombre' => 'Médico', 'descripcion' => 'Responsable de la atención médica primaria, diagnóstico inicial y derivación a especialistas.'],
            ['nombre' => 'Médico Especialista', 'descripcion' => 'Profesional con formación avanzada en un área específica (ej. Cirugía, Cardiología, Pediatría).'],
            ['nombre' => 'Licenciado(a) en Enfermería', 'descripcion' => 'Profesional universitario responsable de la planificación, ejecución y evaluación de los cuidados del paciente.'],
            ['nombre' => 'Técnico(a) en Enfermería', 'descripcion' => 'Asiste al personal de enfermería en procedimientos, toma de signos vitales y cuidados básicos del paciente.'],
            ['nombre' => 'Auxiliar de Enfermería', 'descripcion' => 'Apoya en tareas de cuidados básicos, movilización de pacientes, higiene, confort y alimentación.'],
            
            ['nombre' => 'Técnico(a) Radiólogo(a)', 'descripcion' => 'Opera equipos de diagnóstico por imagen (Rayos X, Tomografías, etc.) y asiste en procedimientos.'],
            ['nombre' => 'Técnico(a) de Laboratorio', 'descripcion' => 'Realiza la toma de muestras y el procesamiento de análisis clínicos solicitados.'],
            ['nombre' => 'Fisioterapeuta', 'descripcion' => 'Profesional encargado de la rehabilitación física, terapia y recuperación funcional de pacientes.'],
            ['nombre' => 'Auxiliar de Farmacia', 'descripcion' => 'Asiste al farmacéutico en la dispensación de medicamentos, control de inventario y preparación de dosis.'],

            ['nombre' => 'Personal Administrativo', 'descripcion' => 'Encargado de admisiones, gestión de citas, expedientes clínicos y atención al público.'],
            ['nombre' => 'Personal de Cocina', 'descripcion' => 'Responsable de la preparación de alimentos y dietas específicas para pacientes según prescripción.'],
            ['nombre' => 'Personal de Mantenimiento', 'descripcion' => 'Encargado de la reparación y mantenimiento preventivo de las instalaciones y equipo general.'],
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }
    }
}
