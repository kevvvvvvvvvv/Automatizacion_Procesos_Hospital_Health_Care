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
        Inertia::render('pacientes/index',['pacientes'=>$pacientes]);
    }
}
