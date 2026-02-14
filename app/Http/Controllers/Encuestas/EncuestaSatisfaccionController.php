<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use App\Http\Requests\Encuestas\EncuestaSatisfaccionRequest;
use App\Models\Estancia;
use Illuminate\Support\Facades\Auth;
use App\Models\Encuestas\EncuestaSatisfaccion;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EncuestaSatisfaccionController extends Controller
{
    public function create(Estancia $estancia)
    {
        $estancia->load('paciente');

        return Inertia::render('formularios/encuestas-satisfacciones/create', [
            'estancia' => $estancia,
        ]);
    }

    public function store(EncuestaSatisfaccionRequest $request, Estancia $estancia)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            // 1. Crear el registro en la tabla general de instancias
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_ENCUESTA_SATISFACCION,
                'user_id' => Auth::id(),
            ]);

            // 2. Crear el detalle de la encuesta usando el mismo ID de la instancia
            // Quitamos estancia_id de validatedData si no existe en la tabla encuesta_satisfaccions
            EncuestaSatisfaccion::create([
                'id' => $formularioInstancia->id,
                ...$validatedData
            ]);

            DB::commit();

            return Redirect::route('estancias.show', $estancia->id)
                ->with('success', 'Se ha creado la encuesta de satisfacción');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al crear la encuesta: ' . $e->getMessage());
        }
    }

    // Corregido: Recibe el ID de la encuesta, no el Request de validación directamente
    public function edit(EncuestaSatisfaccion $encuesta_satisfaccion)
    {
        // Cargamos las relaciones necesarias para el formulario de edición
        $encuesta_satisfaccion->load([
            'formularioInstancia.user', 
            'formularioInstancia.estancia.paciente'
        ]);

      return Inertia::render('formularios/encuestas-satisfacciones/edit', [
            'encuesta' => $encuesta_satisfaccion, // Asegúrate de que la llave sea 'encuesta'
            'estancia' => $encuesta_satisfaccion->formularioInstancia->estancia,
        ]);
    }
    public function update( EncuestaSatisfaccionRequest $request, EncuestaSatisfaccion $encuesta_satisfaccion){
        $validatedData = $request->validated();
        $encuesta_satisfaccion->update($validatedData);
        $estancia = $encuesta_satisfaccion->formularioInstancia->estancia;
        $paciente = $estancia->paciente;
        return Inertia::render('formularios/encuestas-satisfacciones/show', [
            'encuestaSatisfaccion' => $encuesta_satisfaccion,
            'estancia' => $estancia,
            'paciente' => $paciente
        ])->with('succes', 'Encuesta actualizada');
    }
    public function show(EncuestaSatisfaccion $encuesta_satisfaccion)
    {
         $encuesta_satisfaccion->load([
            'formularioInstancia.user', 
            'formularioInstancia.estancia.paciente'
        ]);
        $estancia = $encuesta_satisfaccion->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

        //dd($encuesta_satisfaccion->toArray());
        return Inertia::render('formularios/encuestas-satisfacciones/show', [
            'encuestaSatisfaccion' => $encuesta_satisfaccion,
            'estancia' => $estancia,
            'paciente' => $paciente
        ]);
    }

    public function generarPDF(EncuestaSatisfaccion $encuesta_satisfaccion)
    {
        dd($encuesta_satisfaccion);
        $encuesta_satisfaccion->load(
            'formularioInstancia.estancia.paciente'
        );

        $estancia = $encuesta_satisfaccion->formularioInstancia->estancia;
        $paciente = $estancia->paciente;
          $headerData = [
            'encuesta_satisfaccion' => $encuesta_satisfaccion,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ];
        $viewData = [
            'notaData' => $encuesta_satisfaccion,
            'pacientte' => $paciente,
        ];
        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.encuesta-satisfaccions',
            $viewData,
            $headerData,
            'encuesta-satisfaccions-',
            $estancia->folio,
        );
    }
}