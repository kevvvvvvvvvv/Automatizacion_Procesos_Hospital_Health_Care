<?php

namespace App\Http\Controllers\Cajero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Venta\Pago;
use App\Models\Venta\DetalleVenta;
use App\Models\Venta\Venta;

class WebhookController extends Controller
{
    public function recibirPago(Request $request)
    {
        if ($request->input('clave') !== 'terminoPago') {
            Log::warning("Webhook cajero: Clave no reconocida", $request->all());
            return response()->json(['error' => 'Evento no reconocido'], 400);
        }

        $folioPago = $request->input('folioVenta');

        try {
            DB::transaction(function () use ($request, $folioPago) {
                
                $pago = Pago::with(['detalles.detalleVenta', 'venta'])
                            ->where('folio', $folioPago)
                            ->firstOrFail();

                if ($pago->referencia) {
                    Log::info("Webhook cajero: Pago {$folioPago} ya estaba procesado.");
                    return; 
                }

                $pago->update([
                    'referencia'        => $request->input('claveTransaccion'),
                    'monto_ingresado'   => $request->input('ingresado'),
                    'cambio_dispensado' => $request->input('cambioDispensado'),
                    'clave_cajero'      => $request->input('claveCajero'),
                    'metadata_cajero'   => $request->all(), 
                ]);

                foreach ($pago->detalles as $detallePago) {
                    $detalleVenta = $detallePago->detalleVenta;
                    $nuevoMontoPagado = ($detalleVenta->monto_pagado ?? 0) + $detallePago->monto_aplicado;
                    
                    $nuevoEstadoItem = ($nuevoMontoPagado >= $detalleVenta->total_facturado) 
                                        ? DetalleVenta::ESTADO_PAGADO 
                                        : DetalleVenta::ESTADO_PARCIAL;

                    $detalleVenta->update([
                        'monto_pagado' => $nuevoMontoPagado,
                        'estado'       => $nuevoEstadoItem
                    ]);
                }

                $venta = $pago->venta;
                
                $totalPagadoGlobal = $venta->pagos()->whereNotNull('referencia')->sum('monto');
                
                $nuevoEstadoVenta = ($totalPagadoGlobal >= $venta->total)
                                    ? Venta::ESTADO_PAGADO
                                    : (($totalPagadoGlobal > 0) ? Venta::ESTADO_PARCIAL : Venta::ESTADO_PENDIENTE);

                $venta->update([
                    'total_pagado' => $totalPagadoGlobal,
                    'estado'       => $nuevoEstadoVenta
                ]);

            });

            return response("RECIBIDO", 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            Log::error("Error procesando webhook del cajero para folio {$folioPago}: " . $e->getMessage());
            return response("ERROR", 500);
        }
    }
}
