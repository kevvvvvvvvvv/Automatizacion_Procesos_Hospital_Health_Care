<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstanciaRequest;
use Illuminate\Http\Request;
use App\Models\Estancia;
use App\Models\Habitacion;
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
        $paciente->load('estancias','familiarResponsables');
        $habitaciones = Habitacion::where('estado', 'Libre')->where('tipo','Habitación')->get();

        return Inertia::render('estancias/create', [
            'habitaciones' => $habitaciones,
            'paciente' => $paciente,
        ]);
    }

    public function store(EstanciaRequest $request, Paciente $paciente)
    {
        $validatedData = $request->validated();
        
        DB::transaction(function () use ($validatedData, $paciente, $request) {
            
            $fechaHoraCarbon = Carbon::parse($validatedData['fecha_ingreso'])
                                    ->setTimezone(config('app.timezone'));

            $folio = $paciente->id . $fechaHoraCarbon->day . $fechaHoraCarbon->month . $fechaHoraCarbon->year;

            Validator::make(['folio' => $folio], [
                'folio' => 'unique:estancias,folio',
            ], [
                'folio.unique' => 'Ya existe una estancia registrada para este paciente en esta fecha.',
            ])->validate();

            $dataToCreate = [
                'folio' => $folio,
                'fecha_ingreso' => $fechaHoraCarbon->format('Y-m-d H:i:s'),
                'tipo_estancia' => $validatedData['tipo_estancia'],
                'tipo_ingreso' => $validatedData['tipo_ingreso'],
                'estancia_anterior_id' => $validatedData['estancia_referencia_id'] ?? null,
                'modalidad_ingreso' => $validatedData['modalidad_ingreso'],
                'habitacion_id' =>  $request['habitacion_id'] ?? null,
                'familiar_responsable_id' => $request['familiar_responsable_id'] ?? null,
            ];

            $paciente->estancias()->create($dataToCreate);

            if (!empty($dataToCreate['habitacion_id'])) {
                Habitacion::where('id', $dataToCreate['habitacion_id'])
                          ->update(['estado' => 'Ocupado']);
            }
        });

        return Redirect::route('pacientes.show', $paciente->id)
            ->with('success', 'Estancia registrada y habitación actualizada correctamente.');
    }


    public function edit(Estancia $estancia)
    {
        $estancia->load('habitacion');
        $paciente = $estancia->paciente;
        $paciente->load('estancias','familiarResponsables');
        $habitaciones = Habitacion::where('estado','Libre')->get();
        $habitacionActualId = $estancia->habitacion_id;

        if ($habitacionActualId && !$habitaciones->contains('id', $habitacionActualId)) {
            $habitacionActual = Habitacion::find($habitacionActualId);
            if ($habitacionActual) {
                $habitaciones->push($habitacionActual);
            }
        }
        return inertia('estancias/edit', [
            'estancia' => $estancia,
            'paciente' => $paciente,
            'habitaciones' => $habitaciones,
        ]);
    }

    public function update(EstanciaRequest $request, Estancia $estancia)
    {
        $validatedData = $request->validated();
        
        DB::transaction(function () use ($validatedData, $estancia, $request) {
            $habitacionOriginalId = $estancia->getOriginal('habitacion_id');
            
            $fechaHoraCarbon = Carbon::parse($validatedData['fecha_ingreso'])
                                    ->setTimezone(config('app.timezone'));

            if($validatedData['tipo_estancia'] == 'Interconsulta'){
                $request['habitacion_id'] = null;
            }

            $dataToUpdate = [
                // El folio no se actualiza
                'fecha_ingreso' => $fechaHoraCarbon->format('Y-m-d H:i:s'),
                'tipo_estancia' => $validatedData['tipo_estancia'],
                'tipo_ingreso' => $validatedData['tipo_ingreso'],
                'estancia_anterior_id' => $validatedData['estancia_referencia_id'] ?? null,
                'modalidad_ingreso' => $validatedData['modalidad_ingreso'],
                'habitacion_id' =>  $request['habitacion_id'] ?? null,
                'familiar_responsable_id' => $request['familiar_responsable_id'] ?? null,
            ];
            

            $estancia->update($dataToUpdate);
            $nuevaHabitacionId = $request['habitacion_id'] ?? null;


            if ($habitacionOriginalId != $nuevaHabitacionId) {

                if (!empty($habitacionOriginalId)) {
                    Habitacion::where('id', $habitacionOriginalId)->update(['estado' => 'Libre']);
                }
                if (!empty($nuevaHabitacionId)) {
                    Habitacion::where('id', $nuevaHabitacionId)->update(['estado' => 'Ocupado']);
                }
            }
        });

        return Redirect::route('pacientes.show', $estancia->paciente_id)
            ->with('success', 'Estancia actualizada y estado de habitación corregido.');
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
            'formularioInstancias.user',
            'Consentimiento.user',
            // NUEVO: Carga interconsultas con relaciones
            //'interconsultas.creator',  // Carga el creador de cada interconsulta
            //'interconsultas.updater'   // Carga el actualizador de cada interconsulta
        ]);
        
        return Inertia::render('estancias/show', [
            'estancia' => $estancia,
        ]);
    }
}
