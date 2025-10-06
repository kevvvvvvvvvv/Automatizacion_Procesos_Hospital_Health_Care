<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HabitacionController extends Controller
{
    public function index()
    {
        $habitaciones = Habitacion::with('estanciaActiva.paciente')->get();
        return Inertia::render('habitaciones/index',['habitaciones' => $habitaciones]);
    }
}
