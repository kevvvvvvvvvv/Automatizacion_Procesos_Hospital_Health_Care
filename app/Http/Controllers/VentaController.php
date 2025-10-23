<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Paciente;

class VentaController extends Controller
{
    public function index(Paciente $paciente, Estancia $estancia)
    {
        $estancia->load('ventas.user');
        $ventas = $estancia->ventas;

        return Inertia::render('ventas/index',[
            'estancia' => $estancia,
            'paciente' => $paciente,
            'ventas' => $ventas,
        ]);
    }
}
