<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use App\Models\Paciente;
use Illuminate\Http\Request;

use Inertia\Inertia;

class NotaPostanestesicaController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/nota-postanestesica/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
}
