<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstanciaRequest;
use Illuminate\Http\Request;
use App\Models\Estancia;
use Inertia\Inertia;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EstanciaController extends Controller
{
    public function index()
    {
        
    }

    public function create(Paciente $paciente)
    {
        $paciente->load('estancias');
        return Inertia::render('estancias/create', [
            'paciente' => $paciente,
        ]);
    }

    public function store(EstanciaRequest $request, Paciente $paciente)
    {

        $validatedData = $request->validated();
        $fechaHoraCarbon = Carbon::parse($validatedData['fechaIngreso']);
        $folio = $paciente->id . $fechaHoraCarbon->day . $fechaHoraCarbon->month . $fechaHoraCarbon->year;

        Validator::make(['folio' => $folio], [
            'folio' => 'unique:estancias,folio',
        ], [
            'folio.unique' => 'Ya existe una estancia registrada para este paciente en esta fecha.',
        ])->validate();

        $dataToCreate = array_merge(
            $validatedData,
            [
                'folio' => $folio, 
                'fecha_ingreso' => $fechaHoraCarbon->format('Y-m-d H:i:s'), 
                'estancia_anterior_id' => $validatedData['estancia_referencia_id'] ?? null,
            ]
        );

        $paciente->estancias()->create($dataToCreate);

        return Redirect::route('pacientes.show', $paciente->id)
            ->with('success', 'Estancia registrada correctamente.');
    }

    public function show($id)
    {
        $estancia = Estancia::findOrFail($id);
        return Inertia::render('estancias/show',[
            'estancia' => $estancia
        ]);
    }
}
