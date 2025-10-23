<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Estancia;
use Inertia\Inertia;

class FormularioHojaEnfermeriaController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/hojas-enfermerias/create',[
            'paciente' => $paciente,
            'estancia' => $estancia
        ]);
    }
}
