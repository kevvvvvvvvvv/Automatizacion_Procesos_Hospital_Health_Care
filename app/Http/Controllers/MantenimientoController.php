<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MantenimientoController extends Controller
{
    public function index()
    {
        // Aquí podrías cargar datos si fuera necesario
        return Inertia::render('Mantenimiento/index', [
            'status' => session('success'),
        ]);
    }

    public function store(Request $request)
    {
        // Método para procesar los clics o reportes si fuera necesario
    }
}