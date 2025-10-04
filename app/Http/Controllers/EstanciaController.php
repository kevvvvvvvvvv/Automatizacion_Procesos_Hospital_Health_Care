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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
        $fechaHoraCarbon = Carbon::parse($validatedData['fechaIngreso'])
                                ->setTimezone(config('app.timezone'));

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
                'modalidad_ingreso' => 'Particular',
            ]
        );

        $paciente->estancias()->create($dataToCreate);

        return Redirect::route('pacientes.show', $paciente->id)
            ->with('success', 'Estancia registrada correctamente.');
    }


    public function edit(Estancia $estancia)
    {
        $paciente = $estancia->paciente;
        $paciente->load('estancias');

        return inertia('estancias/edit', [
            'estancia' => $estancia,
            'paciente' => $paciente,
        ]);
    }

    public function update(EstanciaRequest $request, Estancia $estancia)
    {

        if ($estancia->fecha_egreso) {
            return Redirect::back()
                ->with('error', 'No se puede editar una estancia que ya tiene fecha de alta.');
        }

        $validatedData = $request->validated();

        $fechaHoraCarbon = Carbon::parse($validatedData['fechaIngreso'])
                                ->setTimezone(config('app.timezone'));
        
        $folio = $estancia->paciente_id . $fechaHoraCarbon->day . $fechaHoraCarbon->month . $fechaHoraCarbon->year;

        Validator::make(['folio' => $folio], [
            'folio' => [
                'required',
                Rule::unique('estancias', 'folio')->ignore($estancia->id),
            ],
        ], [
            'folio.unique' => 'Ya existe otra estancia registrada para este paciente en la fecha seleccionada.',
        ])->validate();

        $numHabitacion = $validatedData['num_habitacion'] ?? null;
        if ($validatedData['tipo_estancia'] === 'Interconsulta') {
            $numHabitacion = null;
        }

        $dataToUpdate = [
            'folio' => $folio,
            'fecha_ingreso' => $fechaHoraCarbon->format('Y-m-d H:i:s'),
            'tipo_estancia' => $validatedData['tipo_estancia'],
            'tipo_ingreso' => $validatedData['tipo_ingreso'],
            'modalidad_ingreso' => 'Particular',
            'num_habitacion' => $numHabitacion,
            'estancia_anterior_id' => $validatedData['estancia_referencia_id'] ?? null,
        ];
        
        $estancia->update($dataToUpdate);

        return Redirect::route('pacientes.show', $estancia->paciente_id)
            ->with('success', 'Estancia actualizada correctamente.');
    }

    public function show(Estancia $estancia)
    {
        $estancia->load([
            'paciente', 
            'creator', 
            'updater',
            'familiarResponsable',
            'habitacion',
            'formularioInstancias.catalogo',
            'formularioInstancias.user'     
        ]);
        
        return Inertia::render('estancias/show', [
            'estancia' => $estancia,
        ]);
    }
}
