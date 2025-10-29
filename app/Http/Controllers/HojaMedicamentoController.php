<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\HojaMedicamento;

class HojaMedicamentoController extends Controller
{
    public function actualizarEstado(Request $request, HojaMedicamento $medicamento)
    {
        $request->validate([
            'estado' => 'required|string|in:solicitado,surtido,entregado', 
        ]);

        $medicamento->update([
            'estado' => $request->estado,
            'farmaceutico_id' => Auth::id(), 
            'fecha_hora_surtido_farmacia' => now(), 
        ]);

        return Redirect::back()->with('success', 'Estado actualizado.');
    }
}
