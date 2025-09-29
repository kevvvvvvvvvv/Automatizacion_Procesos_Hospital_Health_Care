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
        
        return Inertia::render('pacientes/index',['pacientes'=>$pacientes]);
    }

    public function show(Paciente $paciente)
    {
        $paciente = Paciente::with('estancias')->findOrFail($paciente->id);
        return Inertia::render('pacientes/show', [
            'paciente' => $paciente,
        ]);
    }
}
