<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Paciente;
use App\Models\Venta;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function index(Paciente $paciente, Estancia $estancia)
    {
        $estancia->load('ventas.user');
        $ventas = $estancia->ventas;

        return Inertia::render('ventas/index', [
            'estancia' => $estancia,
            'paciente' => $paciente,
            'ventas' => $ventas,
        ]);
    }

    public function edit(Venta $venta)
    {
      
        $venta->load('estancia.paciente', 'user');

        return Inertia::render('ventas/edit', [
            'venta' => $venta,
            'estancia' => $venta->estancia,
            'paciente' => $venta->estancia?->paciente,
        ]);
    }

    // Actualiza solo el descuento y recalcula total
    public function update(Request $request, Venta $venta)
{
    // Validación
    $validator = Validator::make($request->all(), [
        'descuento_tipo' => ['required', 'string', 'in:monto,porcentaje'],
        'descuento' => ['required', 'numeric', 'min:0'],
    ]);

    $validator->after(function ($validator) use ($request, $venta) {
        $tipo = $request->input('descuento_tipo');
        $valor = (float) $request->input('descuento', 0);

        if ($tipo === 'porcentaje') {
            // porcentaje válido entre 0 y 100
            if ($valor > 100) {
                $validator->errors()->add('descuento', 'El porcentaje no puede ser mayor a 100.');
            }
        } else {
            // monto no puede exceder subtotal
            if ($valor > $venta->subtotal) {
                $validator->errors()->add('descuento', 'El descuento no puede ser mayor que el subtotal.');
            }
        }
    });

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $tipo = $request->input('descuento_tipo');
    $valor = (float) $request->input('descuento', 0);

    if ($tipo === 'porcentaje') {
        $descuentoMonto = round($venta->subtotal * ($valor / 100), 2);
    } else {
        $descuentoMonto = round($valor, 2);
    }

    // seguridad: no permitir descuento negativo o mayor al subtotal
    if ($descuentoMonto < 0) {
        $descuentoMonto = 0;
    }
    if ($descuentoMonto > $venta->subtotal) {
        $descuentoMonto = $venta->subtotal;
    }

    $venta->descuento = $descuentoMonto;
    $venta->total = round($venta->subtotal - $descuentoMonto, 2);
    $venta->save();

    // redirige a index de ventas (ajusta la ruta según tu configuración)
    return redirect()->route('pacientes.estancias.ventas.index', [
        'paciente' => $venta->estancia->paciente_id,
        'estancia' => $venta->estancia_id,
    ])->with('success', 'Descuento actualizado correctamente.');
}

}
