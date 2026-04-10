<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
// Asegúrate de que este sea el path correcto de tu modelo
use App\Models\Formulario\RecienNacido\Somatometria; 
use App\Models\Formulario\RecienNacido\RecienNacido;

class SomatometriaController extends Controller
{
    /**
     * Almacena un nuevo registro de somatometría.
     * Nota: Cambié el parámetro a RecienNacido $reciennacido para que coincida con tu ruta.
     */
    public function store(Request $request, RecienNacido $reciennacido)
    {
        // 1. Validación de los datos
        $validated = $request->validate([
            'perimetro_cefalico'  => 'nullable|numeric',
            'perimetro_toracico'  => 'nullable|numeric',
            'perimetro_abdominal' => 'nullable|numeric',
            'pie'                 => 'nullable|numeric',
            'segmento_inferior'   => 'nullable|numeric',
            'capurro'             => 'nullable|string',
            'apgar'               => 'nullable|string',
            'silverman'           => 'nullable|integer',
        ]);

        try {
            // 2. Creación del registro vinculado al Recién Nacido
            Somatometria::create([
                'hoja_enfermeria_id' => $reciennacido->id, // El ID que viene de la URL
                'fecha_hora_registro' => now(), // O puedes usar $request->fecha_hora_registro si lo envías
                'perimetro_cefalico'  => $validated['perimetro_cefalico'],
                'perimetro_toracico'  => $validated['perimetro_toracico'],
                'perimetro_abdominal' => $validated['perimetro_abdominal'],
                'pie'                 => $validated['pie'],
                'segmento_inferior'   => $validated['segmento_inferior'],
                'capurro'             => $validated['capurro'],
                'apgar'               => $validated['apgar'],
                'silverman'           => $validated['silverman'],
            ]);

            return Redirect::back()->with('success', 'Somatometría registrada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error en SomatometriaController@store: ' . $e->getMessage());
            
            return Redirect::back()->with('error', 'Hubo un problema al guardar los datos.');
        }
    }

    public function update(Request $request, Somatometria $somatometria)
    {
        // Lógica similar al store pero usando $somatometria->update($validated);
    }
}