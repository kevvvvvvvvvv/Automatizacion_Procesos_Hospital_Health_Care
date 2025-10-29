<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Venta;

use Illuminate\Http\Request;
use inertia\Inertia;

class DetalleVentaController extends Controller
{
    public function index(Paciente $paciente, Estancia $estancia, Venta $venta)
    {

        $venta->load(['detalles.productoServicio']);
        //dd($venta->toArray());

        return Inertia::render('ventas/detalles/index', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'venta' => $venta, 
        ]);
    }
}
