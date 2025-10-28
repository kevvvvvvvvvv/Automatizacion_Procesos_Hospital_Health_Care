<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use App\Models\ProductoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FormularioHojaTerapiaIVController extends Controller
{
    public function store(Request $request, HojaEnfermeria $hojasenfermeria)
    {
        $validatedData = $request->validate([
            'terapias_agregadas' => 'required|array|min:1',
            'terapias_agregadas.*.solucion_id' => 'required|exists:producto_servicios,id',
            'terapias_agregadas.*.flujo' => 'required|numeric',
        ]);
        foreach ($validatedData['terapias_agregadas'] as $terapia) {

            //$producto = ProductoServicio::findOrFail($terapia);
            $hojasenfermeria->hojasTerapiaIV()->create([
                'solucion' => $terapia['solucion_id'],
                'flujo_ml_hora' => $terapia['flujo'],
                'fecha_hora_inicio' => $terapia['fecha_hora_inicio'] ?? null,
            ]);
        }

        return Redirect::back()->with('success', 'Terapias guardadas exitosamente.');
    }
}
