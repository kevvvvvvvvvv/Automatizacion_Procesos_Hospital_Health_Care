<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Services\VentaService; 
use App\Models\HojaMedicamento; 
use Illuminate\Support\Facades\DB;

use App\Models\HojaEnfermeria;

use Inertia\Inertia;

class FarmaciaController extends Controller
{
    public function show(HojaEnfermeria $hojaenfermeria)
    {

        $hojaenfermeria->load([
                'formularioInstancia.estancia.paciente',
                'hojaMedicamentos' => function ($query) {
                    $query->whereIn('estado', ['solicitado', 'surtido']);
                },
                'hojaMedicamentos.productoServicio' 
            ]);

        return Inertia::render('farmacia/show', [
            'hoja' => $hojaenfermeria,
            'paciente' => $hojaenfermeria->formularioInstancia->estancia->paciente,
        ]);
    }

}
