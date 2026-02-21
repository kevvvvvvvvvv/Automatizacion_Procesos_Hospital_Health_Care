<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroPagoVentaRequest;
use App\Models\Estancia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Paciente;
use App\Models\Venta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Services\VentaService;

class VentaController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar ventas', only: ['index', 'show']),
            new Middleware($permission . ':crear ventas', only: ['create', 'store']),
            new Middleware($permission . ':editar ventas', only: ['edit', 'update']),
            new Middleware($permission . ':eliminar ventas', only: ['destroy']),
        ];
    }

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

    public function show(Venta $venta)
    {
        $venta->load('estancia.paciente','detalles.itemable');
        //dd($venta->toArray());
        return Inertia::render('ventas/show', ['venta' => $venta]);
    }

    public function edit(Venta $venta)
    {
      
        $venta->load(
            'estancia.paciente', 
            'user',
            'detalles.itemable');

        $productos = \App\Models\ProductoServicio::all()->map(function($p) {
            return [
                'value' => 'producto-' . $p->id, 
                'label' => $p->nombre_prestacion,
                'precio' => $p->importe,
                'type'  => 'producto',
                'real_id' => $p->id
            ];
        });

        $estudios = \App\Models\CatalogoEstudio::all()->map(function($e) {
            return [
                'value' => 'estudio-' . $e->id,
                'label' => $e->nombre,
                'precio' => $e->costo,
                'type'  => 'estudio',
                'real_id' => $e->id
            ];
        });

        $catalogo = $productos->concat($estudios);

        return Inertia::render('ventas/edit', [
            'venta' => $venta,
            'estancia' => $venta->estancia,
            'paciente' => $venta->estancia?->paciente,
            'catalogoOptions' => $catalogo,
        ]);
    }

    // Actualiza solo el descuento y recalcula total
    public function update(Request $request, Venta $venta)
    {
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

        return redirect()->route('pacientes.estancias.ventas.index', [
            'paciente' => $venta->estancia->paciente_id,
            'estancia' => $venta->estancia_id,
        ])->with('success', 'Descuento actualizado correctamente.');
    }


    public function registrarPago(RegistroPagoVentaRequest $request, Venta $venta, VentaService $ventaService)
    {
        $validatedData = $request->validated();

        try {
            $montoAbonado = $validatedData['total_pagado'];

            $ventaService->registrarPago($venta, $montoAbonado);
            $venta->update(
                ['requiere_factura' => $validatedData['requiere_factura']]
            );

            return Redirect::back()->with('success', 'Se ha registrado el pago correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al registrar el pago: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al registrar el pago.');
        }
    }
}
