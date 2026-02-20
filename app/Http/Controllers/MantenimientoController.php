<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
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
    // En tu Controller
    // MantenimientoController.php
public function storeInitialRequest(Request $request) {
    $solicitud = SolicitudMantenimiento::create([
        'tipo' => $request->tipo,
        'estado' => 'esperando_personal',
        'sucursal' => 'Plan de Ayutla',
        'hora_solicitud' => now(),
    ]);

    // Disparamos el evento para tiempo real
    event(new SolicitudCreada($solicitud));

    return redirect()->route('mantenimiento.create', ['id' => $solicitud->id]);
}
public function create(Request $request)
{
    // Asegúrate de que estás obteniendo las habitaciones de tu modelo
    $habitaciones = Habitacion::all(); 

    return Inertia::render('Mantenimiento/create', [
        'habitaciones' => $habitaciones, // <--- ESTO es lo que le falta a tu React
        'habitacion_id' => $request->query('habitacion_id'),
        'tipo' => $request->query('tipo')
    ]);
}

    public function store(Request $request)
    {
        // Método para procesar los clics o reportes si fuera necesario
    }
}