<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use App\Http\Requests\Caja\Traspaso\EnviarABovedaRequest;
use App\Http\Requests\Caja\Traspaso\ResponderRequest;
use App\Http\Requests\Caja\Traspaso\SolicitudTraspasoRequest;
use Illuminate\Http\Request;

use App\Services\CajaService;

use App\Models\Caja\SolicitudTraspaso;
use Illuminate\Support\Facades\Redirect;

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
    public function solicitar(SolicitudTraspasoRequest $request)
    {
        $validated = $request->validated(); 

        try {
            $this->cajaService->tomarDineroDeFondo(
                $validated['caja_destino_id'],
                $validated['monto'],
                $validated['concepto'],
                $request->user()->id
            );

            return redirect()->back()->with('success', 'Dinero transferido a tu caja exitosamente. Se ha notificado a Bóveda para reponer el fondo.');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    /**
     * Contaduría / Fondo aprueba o rechaza la petición
     */
    public function responder(ResponderRequest $request, SolicitudTraspaso $solicitud)
    {
        $validated = $request->validated();

        try {
            $this->cajaService->responderTraspaso(
                $solicitud,
                $validated['aprobar'],
                $validated['monto_aprobado'] ?? 0, 
                $request->user()->id
            );

            $mensaje = $validated['aprobar'] ? 'Traspaso autorizado y dinero enviado.' : 'Solicitud rechazada.';
            return redirect()->back()->with('success', $mensaje);
            
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    public function enviarABoveda(EnviarABovedaRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->cajaService->enviarDineroABoveda(
                $validated['caja_origen_id'],
                $validated['monto'],
                $validated['concepto'],
                $request->user()->id
            );

            return redirect()->back()->with('success', 'Dinero descontado de tu caja y enviado a Contaduría.');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

}
