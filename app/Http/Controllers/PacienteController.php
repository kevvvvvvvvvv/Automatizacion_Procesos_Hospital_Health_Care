<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Inertia\Inertia;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes=Paciente::all();
        
        return Inertia::render('pacientes/Index',['pacientes'=>$pacientes]);
    }

    public function show(Paciente $paciente)
    {
        return Inertia::render('pacientes/Show', [
            'paciente' => $paciente
        ]);
    }
}
