<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use Carbon\Carbon;
use Inertia\inertia;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReservacionRequest;
use Redirect;
use App\Models\Habitacion;
use App\Models\ReservacionHorario;
use Illuminate\Support\Facades\Auth;

class ReservacionController extends Controller
        {
        public function index(){
                $reservacion = Reservacion::all();
                return Inertia::render('reservacion/index', [
                    'reservacion' => $reservacion
                ]);
            }
            
        public function create()
                {
                    // Localizaciones disponibles
                    $localizaciones = [
                        [
                            'value' => 'plan_ayutla',
                            'label' => 'Plan de Ayutla',
                            'limite' => 5,
                        ],
                        [
                            'value' => 'acapantzingo',
                            'label' => 'Diaz ordas',
                            'limite' => 3,
                        ],
                    ];

                    // Generar horarios de 00:00 a 23:30 cada 30 minutos
                    $horarios = [];
                    $inicio = Carbon::createFromTime(0, 0);
                    $fin = Carbon::createFromTime(23, 30);

                    while ($inicio <= $fin) {
                        $horarios[] = $inicio->format('H:i');
                        $inicio->addMinutes(30);
                    }

                    return Inertia::render('reservacion/create', [
                        'localizaciones' => $localizaciones,
                        'horarios' => $horarios,
                    ]);
                }

        public function store(ReservacionRequest $request)
        {
            $data = $request->validated();
            
            DB::beginTransaction();

            try {

                $userId = Auth::id();
                $localizacion = $data['localizacion'];
                
                $fecha = $data['fecha'];
                
                $horarios = $data['horarios'];
                dd($horarios);
                // Límite por localización
                $limite = $localizacion === 'plan_ayutla' ? 5 : 3;
                dd($limite); 
                foreach ($horarios as $hora) {

                    // 🔢 Cuántas reservaciones ya existen en ese horario
                    $ocupados = ReservacionHorario::where('fecha_hora', $hora)
                        ->whereHas('reservacion', function ($q) use ($localizacion, $fecha) {
                            $q->where('localizacion', $localizacion)
                            ->where('fecha', $fecha);
                        })
                        ->count();

                    // El siguiente consultorio
                    $numeroConsultorio = $ocupados + 1;

                    if ($numeroConsultorio > $limite) {
                        throw new \Exception('No hay consultorios disponibles.');
                    }

                    // 🏥 Obtener el consultorio correspondiente
                    $consultorio = Habitacion::where('tipo', 'consultorio')
                        ->orderBy('id')
                        ->skip($numeroConsultorio - 1)
                        ->first();

                    if (!$consultorio) {
                        throw new \Exception('Consultorio no encontrado.');
                    }

                    $reservacion = Reservacion::create([
                        'localizacion' => $localizacion,
                        'fecha' => $fecha,
                        'habitacion_id' => $consultorio->id,
                        'user_id' => $userId,
                    ]);

                    // ⏰ Guardar horario
                    $reservacion->horarios()->create([
                        'fecha_hora' => $hora,
                    ]);
                }
                
                DB::commit();

                return redirect()
                    ->route('reservaciones.index')
                    ->with('success', 'Reservación creada correctamente');

            } catch (\Throwable $e) {

                DB::rollBack();

                return back()
                    ->withErrors([
                        'error' => $e->getMessage()
                    ])
                    ->withInput();
            }
        }
    }
