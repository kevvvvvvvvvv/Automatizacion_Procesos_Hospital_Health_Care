<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Formulario\HojaEnfermeria\HojaMedicamento;

class HojaMedicamentoController extends Controller
{ 
    public function actualizarEstado(Request $request, HojaMedicamento $medicamento)
    {
        $validated = $request->validate([
            'estado' => 'required|string|in:surtido,entregado',
        ]);

        // Solo permitir el cambio si está en estado 'solicitado'
        if ($medicamento->estado !== 'solicitado') {
            return Redirect::back()->with('error', 'Este medicamento ya fue procesado.');
        }

        try {
            $medicamento->update([
                'estado' => $validated['estado'],
                'farmaceutico_id' => Auth::id(), 
                'fecha_hora_surtido_farmacia' => now(), 
            ]);

            return Redirect::back()->with('success', 'Estado del medicamento actualizado correctamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar estado del medicamento: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al cambiar el estado.');
        }
    }
}