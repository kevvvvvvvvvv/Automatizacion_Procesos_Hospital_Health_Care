<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroPagoVentaRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Services\VentaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Venta\Venta;
use App\Models\Venta\DetalleVenta;
use App\Models\Venta\Pago;
use App\Models\Venta\DetallePago;
use App\Models\Paciente;
use App\Models\Venta\MetodoPago;
use App\Models\Estancia;
use App\Models\Inventario\ProductoServicio;
use App\Models\Estudio\CatalogoEstudio;

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
        $venta->load(
            'estancia.paciente',
            'detalles.itemable',
            'pagos.detalles',
            'pagos.metodoPago',
            'pagos.venta.detalles',
        );
        $metodosPago = MetodoPago::all();
        return Inertia::render('ventas/show', [
            'venta' => $venta,
            'metodosPago' => $metodosPago,
        ]);
    }

    public function edit(Venta $venta)
    {
      
        $venta->load(
            'estancia.paciente', 
            'user',
            'detalles.itemable');

        $catalogo = ProductoServicio::all()->map(function($p) {
            return [
                'value' => 'producto-' . $p->id, 
                'label' => $p->nombre_prestacion,
                'precio' => $p->importe,
                'type'  => 'producto',
                'real_id' => $p->id
            ];
        });

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


    public function registrarPago(Request $request, Venta $venta)
    {
        $request->validate([
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'detalles_pago' => 'required|array',
        ]);

        //dd($request->toArray());

        DB::beginTransaction();
        try {
            $totalAbono = collect($request->detalles_pago)->sum('monto_aplicado');

            if ($totalAbono <= 0) {
                return back()->withErrors(['error' => 'El monto debe ser mayor a 0']);
            }

            $ultimoPago = Pago::latest('id')->first();
            $siguienteId = $ultimoPago ? $ultimoPago->id + 1 : 1;
            $folioPago = str_pad($siguienteId, 6, '0', STR_PAD_LEFT);
            $montoRestante = $venta->saldo_pendiente - $totalAbono;

            $pago = Pago::create([
                'folio' => $folioPago,
                'venta_id' => $venta->id,
                'metodo_pago_id' => $request->metodo_pago_id,
                'monto' => $totalAbono,
                'monto_restante' => $montoRestante,
                'user_id' => Auth::id(),
            ]);
            //dd($pago->toArray());
            foreach ($request->detalles_pago as $item) {
                if ($item['monto_aplicado'] > 0) {
                    DetallePago::create([
                        'pago_id' => $pago->id,
                        'detalle_venta_id' => $item['detalle_venta_id'],
                        'monto_aplicado' => $item['monto_aplicado'],
                    ]);

                    $detalleVenta = DetalleVenta::find($item['detalle_venta_id']);
                    $detalleVenta->increment('monto_pagado', $item['monto_aplicado']);
                }
            }

            $venta->increment('total_pagado', $totalAbono);
            //dd($venta->toArray());
            DB::commit();
            return back()->with('success', 'Pago registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Hubo un problema al registrar el pago: ' . $e->getMessage()]);
        }
    }
}
