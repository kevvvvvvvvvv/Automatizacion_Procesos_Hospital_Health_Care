<?php

namespace App\Http\Controllers;


use App\Models\Formulario\RecienNacido\RecienNacido;
use App\Models\Formulario\RecienNacido\Ingresos_Egresos_RN; // Asumiendo que este es el nombre de tu modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IngresosEgresosRNController extends Controller
{
    /**
     * Almacena un nuevo registro de control de líquidos para el recién nacido.
     */
    public function store(Request $request, $id)
    {
        // 1. Validar los datos
        $validated = $request->validate([
            'seno'              => 'nullable|string',
            'formula'           => 'nullable|numeric',
            'otros_ingresos'    => 'nullable|string',
            'cantidad_ingresos' => 'required_with:otros_ingresos|nullable|numeric',
            'miccion'           => 'nullable|string',
            'evacuacion'        => 'nullable|string',
            'emesis'            => 'nullable|numeric',
            'otros_egresos'     => 'nullable|string',
            'cantidad_egresos'  => 'required_with:otros_egresos|nullable|numeric',
        ]);
        //dd($validated);
        $neonato = RecienNacido::findOrFail($id);

        // 3. Calcular Balance Total

        $totalIngresos = (float)($request->formula ?? 0) + (float)($request->cantidad_ingresos ?? 0);
        $totalEgresos  = (float)($request->emesis ?? 0) + (float)($request->cantidad_egresos ?? 0);
        
        $balanceTotal = $totalIngresos - $totalEgresos;
           // dd($balanceTotal);

       $neonato->Ingresos_Egresos_RN()->create([
            'seno_materno'      => $request->seno, // Cambiado para que coincida con la migración
            'formula'           => $request->formula,
            'otros_ingresos'    => $request->otros_ingresos,
            'cantidad_ingresos' => $request->cantidad_ingresos,
            'miccion'           => $request->miccion,
            'evacuacion'        => $request->evacuacion,
            'emesis'            => $request->emesis,
            'otros_egresos'     => $request->otros_egresos,
            'cantidad_egresos'  => $request->cantidad_egresos,
            'balance_total'     => $balanceTotal,
        ]);
                  //  dd($neonato);

        // 5. Redireccionar con mensaje de éxito
        return Redirect::back()->with('success', 'Control de líquidos registrado correctamente.');
    }

    /**
     * Opcional: Método para eliminar registros si fuera necesario
     */
    public function destroy($id)
    {
        $registro = Ingresos_Egresos_RN::findOrFail($id);
        $registro->delete();

        return Redirect::back()->with('success', 'Registro eliminado.');
    }
}