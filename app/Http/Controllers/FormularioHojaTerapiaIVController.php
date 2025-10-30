<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use App\Models\ProductoServicio;
use App\Models\HojaTerapiaIV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class FormularioHojaTerapiaIVController extends Controller
{
    public function store(Request $request, HojaEnfermeria $hojasenfermeria)
    {
        $validatedData = $request->validate([
            'terapias_agregadas' => 'required|array|min:1',
            'terapias_agregadas.*.solucion_id' => 'required|exists:producto_servicios,id',
            'terapias_agregadas.*.cantidad' => 'required|numeric',
            'terapias_agregadas.*.duracion' => 'required|numeric',
            'terapias_agregadas.*.flujo' => 'required|numeric',
        ]);

        foreach ($validatedData['terapias_agregadas'] as $terapia) {

            //$producto = ProductoServicio::findOrFail($terapia);
            $hojasenfermeria->hojasTerapiaIV()->create([
                'solucion' => $terapia['solucion_id'],
                'flujo_ml_hora' => $terapia['flujo'],
                'fecha_hora_inicio' => $terapia['fecha_hora_inicio'] ?? null,
                'duracion' => $terapia['duracion'],
                'cantidad' => $terapia['cantidad'],
            ]);
        }

        return Redirect::back()->with('success', 'Terapias guardadas exitosamente.');
    }

    public function update(Request $request, HojaEnfermeria $hojasenfermeria, HojaTerapiaIV $hojasterapiasiv)
    {
        $validated = $request->validate([
            'fecha_hora_inicio' => ['required', 'date'],
        ]);

        $fechaMySQL = Carbon::parse($validated['fecha_hora_inicio'])
                    ->setTimezone(config('app.timezone'))
                    ->format('Y-m-d H:i:s');

        if ($hojasterapiasiv->hoja_enfermeria_id !== $hojasenfermeria->id) {
            abort(403, 'Acción no autorizada.');
        }

        $hojasterapiasiv->update([
            'fecha_hora_inicio' => $fechaMySQL,
        ]);

        return Redirect::back()->with('success', 'Fecha de terapia actualizada.');
    }
}
