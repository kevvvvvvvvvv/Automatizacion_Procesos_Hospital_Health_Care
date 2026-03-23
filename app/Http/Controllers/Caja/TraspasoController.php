<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\CajaService;

use App\Models\Caja\SolicitudTraspaso;

class TraspasoController extends Controller
{
protected $cajaService;

    public function __construct(CajaService $cajaService)
    {
        $this->cajaService = $cajaService;
    }

    /**
     * El Cajero pide dinero al Fondo
     */
    public function solicitar(Request $request)
    {
        $validated = $request->validate([
            'caja_origen_id' => 'required|exists:cajas,id', // A quién le pide (El Fondo)
            'caja_destino_id' => 'required|exists:cajas,id', // Quién pide (Urgencias)
            'monto' => 'required|numeric|min:1',
            'concepto' => 'required|string|max:255',
        ]);

        try {
            $this->cajaService->solicitarTraspaso(
                $validated['caja_origen_id'],
                $validated['caja_destino_id'],
                $validated['monto'],
                $validated['concepto'],
                $request->user()->id
            );

            return redirect()->back()->with('success', 'Solicitud enviada exitosamente. Esperando autorización.');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    /**
     * Contaduría / Fondo aprueba o rechaza la petición
     */
    public function responder(Request $request, SolicitudTraspaso $solicitud)
    {
        $validated = $request->validate([
            'aprobar' => 'required|boolean',
            'monto_aprobado' => 'required_if:aprobar,true|numeric|min:0', // Solo es obligatorio si aprueba
        ]);

        try {
            $this->cajaService->responderTraspaso(
                $solicitud,
                $validated['aprobar'],
                $validated['monto_aprobado'] ?? 0, // Si rechazó, mandamos 0
                $request->user()->id
            );

            $mensaje = $validated['aprobar'] ? 'Traspaso autorizado y dinero enviado.' : 'Solicitud rechazada.';
            return redirect()->back()->with('success', $mensaje);
            
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }
}
