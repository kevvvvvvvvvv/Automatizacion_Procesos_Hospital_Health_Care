<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\HojaEscalaValoracion;
use App\Http\Requests\HojaEscalaValoracionRequest;
use App\Models\HojaEnfermeria;
use App\Models\ValoracionDolor;
use Illuminate\Support\Facades\DB;


class HojaEscalaValoracionController extends Controller
{
    public function store(HojaEscalaValoracionRequest $request,HojaEnfermeria $hojasenfermeria)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try{
            $hoja = HojaEscalaValoracion::create([
                'hoja_enfermeria_id' => $hojasenfermeria->id,
                'fecha_hora_registro' => now(),
                'escala_braden'       => $validatedData['escala_braden'] ?? null,
                'escala_glasgow'      => $validatedData['escala_glasgow'] ?? null,
                'escala_ramsey'       => $validatedData['escala_ramsey'] ?? null,
            ]);

            if (!empty($validatedData['valoracion_dolor'])) {
                foreach ($validatedData['valoracion_dolor'] as $dolor) {
                    ValoracionDolor::create([
                        'escala_eva'                => $dolor['escala_eva'],
                        'ubicacion_dolor'           => $dolor['ubicacion_dolor'] ?? null,
                        'hoja_escala_valoracion_id' => $hoja->id
                    ]);
                }
            }

            DB::commit();
            return Redirect::back()->with('success', 'Registro de escalas de valoración guardados exitosamente.');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al guardar las escalas de valoracion: ' .$e->getMessage());
            return Redirect::back()->with('error','Error al guardar el registro de las escalas de valoración.');
        }

    }
}
