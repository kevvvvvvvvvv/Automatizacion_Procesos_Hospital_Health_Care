<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Venta\Pago;

class QpminiService
{
    /**
     * Solicita el QR de pago al cajero basándose en un Pago creado en el sistema
     */
    public function generarCodigoQr(Pago $pago, string $tipoPago = '')
    {
        if ($pago->detalles->isEmpty()) {
            throw new \Exception("El pago no tiene artículos asignados.");
        }

        $venta = $pago->venta;
        $productosQpmini = [];
        
        foreach ($pago->detalles as $detallePago) {
            $dv = $detallePago->detalleVenta;
            
            $porcentajeIva = $dv->iva_aplicado ?? 0;
            $subtotalProducto = $dv->subtotal; 
            $montoIvaProducto = $subtotalProducto * ($porcentajeIva / 100);
            $totalConIva = $subtotalProducto + $montoIvaProducto;

            $productosQpmini[] = [
                'cantidad'             => (float) $dv->cantidad,
                'producto'             => $dv->nombre_producto_servicio ?? 'Servicio',
                'monto'                => round($totalConIva, 2), 
                'subtotal'             => round($subtotalProducto, 2), 
                'IVA'                  => round($montoIvaProducto, 2),
                'IVA_Porcen'           => (float) $porcentajeIva,
                'PrecioUnitarioVenta'  => (float) $dv->precio_unitario,
                'UM'                   => 'Pz', 
                'Categoria'            => 'General',
                'SubCategoria'         => ''
            ];
        }

        $subtotalGlobal = $pago->subtotal_ventas; 
        $ivaGlobal = $pago->iva_ventas;           
        $montoReal = $subtotalGlobal + $ivaGlobal;
        $montoRedondeado = round($montoReal, 2);

        $payload = [
            'clave'       => 'generarCodigoImagenPago',
            'usuario'     => env('QPMINI_USUARIO', 'cajero1'),
            'monto'       => $montoRedondeado,
            'montoReal'   => $montoReal,
            'tipoPago'    => $tipoPago, 
            'subtotal'    => $subtotalGlobal,
            'IVA'         => $ivaGlobal,
            'folioVenta'  => $pago->folio,
            'IdStatus'    => 0, 
            'vendedor'    => $venta->user ? $venta->user->name : 'Sistema',
            'onlyCode'    => 0, 
            'TipoRecibo'  => 'COMPLETO',
            'noTickets'   => 1,
            'fechaLimite' => now()->addDay()->format('Y-m-d'),
            'token'       => env('QPMINI_TOKEN'),
            'datos'       => $productosQpmini
        ];


        // Peticion a quickpay
        try {
            $url = env('QPMINI_URL') . '/generarCodigoImagenPago';
            
            $response = Http::timeout(10)->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['msg']) && $data['msg'] == "200") {
                    return [
                        'success'  => true,
                        'qr_base64'=> $data['qrcodeImagen'] ?? null,
                        'codigo'   => $data['codigo'] ?? null,
                        'mensaje'  => $data['respuesta'] ?? 'QR Generado con éxito'
                    ];
                }

                return [
                    'success' => false,
                    'mensaje' => $data['respuesta'] ?? 'Error desconocido del cajero'
                ];
            }

            Log::error("Error HTTP al contactar QPMini: " . $response->status(), $response->json() ?? []);
            return [
                'success' => false,
                'mensaje' => 'No se pudo comunicar con el cajero físico.'
            ];

        } catch (\Exception $e) {
            Log::error("Excepción al contactar QPMini: " . $e->getMessage());
            return [
                'success' => false,
                'mensaje' => 'El cajero parece estar apagado o desconectado de la red.'
            ];
        }
    }
}