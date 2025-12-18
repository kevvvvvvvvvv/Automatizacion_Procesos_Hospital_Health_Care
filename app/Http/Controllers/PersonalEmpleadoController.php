<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalEmpleadoRequest;
use Illuminate\Http\Request;
use App\Models\PersonalEmpleado;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Log;

class PersonalEmpleadoController extends Controller
{
    public function store(PersonalEmpleadoRequest $request)
    {
        $validated = $request->validated();

        try{

            $modelMap = [
                'hoja' => \App\Models\HojaEnfermeriaQuirofano::class,
                'nota' => \App\Models\NotaPostoperatoria::class,
            ];

            $modelClass = $modelMap[$validated['itemable_type']];
            $parent = $modelClass::findOrFail($validated['itemable_id']);

            $parent->personalEmpleados()->create([
                'user_id' => $validated['user_id'],
                'cargo'   => $validated['cargo'],
            ]);

            return back()->with('success', 'Personal agregado');

        }catch(Exception $e){
            Log::error('Error al agregar al personal' . $e->getMessage());
            return Redirect::back()->with('error','Error al agregar al personal');
        }


    }

    public function destroy(PersonalEmpleado $personalEmpleado)
    {
        try{
            $personalEmpleado->destroy($personalEmpleado->id);
            return Redirect::back()->with('success','Se ha eliminado el ayudante.');
        }catch(Exception $e){
            Log::error('Error al eliminar al personal: ' . $e->getMessage());
            return Redirect::back()->wirh('error','Error al eliminar al personal');
        }

    }
}
