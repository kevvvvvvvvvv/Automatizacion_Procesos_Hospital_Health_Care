<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaEnfermeriaRequest;
use App\Models\CatalogoEstudio;
use App\Models\CatalogoViaAdministracion;
use App\Models\CategoriaDieta;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use App\Models\HojaEnfermeria;
use App\Models\ProductoServicio;
use App\Models\HojaSignos;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\Middleware;

use App\Services\PdfGeneratorService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;

class FormularioHojaEnfermeriaController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    protected $pdfGenerator;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar hojas enfermerias', only: ['index', 'show']),
            new Middleware($permission . ':crear hojas enfermerias', only: ['create', 'store']),
            new Middleware($permission . ':eliminar hojas enfermerias', only: ['destroy']),
        ];
    }

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        $estancia->load('formularioInstancias.hojaEnfermeria');

        foreach ($estancia->formularioInstancias as $instancia) {
            if ($instancia->hojaEnfermeria && $instancia->hojaEnfermeria->estado == 'Abierto') {
                return Redirect::back()->with('error', 'Se tiene que cerrar la hoja de enfermería antes de crear una nueva');
            }
        }

        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->get();
        $soluciones = ProductoServicio::where('subtipo','INSUMOS')->get();


        return Inertia::render('formularios/hojas-enfermerias/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'medicamentos' => $medicamentos,
            'soluciones' => $soluciones
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia)
    {
        DB::beginTransaction();
        try{
            $formulario = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_HOJA_ENFERMERIA,
                'user_id' =>  Auth::id(),
            ]);
             
            $hoja = HojaEnfermeria::create([
                'id' => $formulario->id,
                'turno' => $request->turno, 
                'observaciones' => $request->observaciones,
                'estado' => 'Abierto',
            ]);
            
            
            DB::commit();

            
            return Redirect::route('hojasenfermerias.edit', $hoja->id)
                   ->with('success', 'Turno iniciado. Ya puede registrar eventos.');
        }catch(\Exception $e){
            DB::rollback();
            return Redirect::back()->with('error', 'Error al iniciar turno: ' . $e->getMessage());
        }
    }

    public function edit(HojaEnfermeria $hojasenfermeria)
    {
        $hojasenfermeria->load(
            'formularioInstancia.estancia.paciente', 
            'hojasTerapiaIV.detalleSoluciones',
            'hojaMedicamentos.productoServicio',
            'hojaMedicamentos.aplicaciones',
            'hojaOxigenos.userInicio',
            'hojaOxigenos.userFin',
            'hojaEscalaValoraciones',
            'hojaControlLiquidos',
            'sondasCateteres.productoServicio',

            'hojaSignos',
            'solicitudesDieta',
            
        );

        $estancia = $hojasenfermeria->formularioInstancia->estancia;
        $paciente = $hojasenfermeria->formularioInstancia->estancia->paciente;

        $columnasGraficas = [
            'fecha_hora_registro',
            'tension_arterial_sistolica',
            'tension_arterial_diastolica',
            'frecuencia_cardiaca',
            'frecuencia_respiratoria',
            'temperatura',
            'saturacion_oxigeno', 
            'glucemia_capilar',
            'talla',
            'peso',
        ];

        $catalogoEstudios = CatalogoEstudio::all();
        $solicitudesAnteriores = $estancia->formularioInstancias
                                ->map(fn($instancia) => $instancia->solicitudEstudio)
                                ->filter() 
                                ->sortByDesc('created_at')
                                ->values();

        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->with('medicamento.viasAdministracion')->get();
        $soluciones = ProductoServicio::where('nombre_prestacion', 'like', 'SOLUCION%')->get();
        $medicos = User::all();
        $usuarios = User::all();
        $categoria_dietas = CategoriaDieta::with('dietas')->get();
        $sondas_cateters = ProductoServicio::where('nombre_prestacion','like','SONDA%')->orWhere('nombre_prestacion', 'like', 'CATETER%')->get();
        $vias_administracion = CatalogoViaAdministracion::all();

        $dataParaGraficas = HojaSignos::select($columnasGraficas)
            ->where('hoja_enfermeria_id', $hojasenfermeria->id)
            ->orderBy('fecha_hora_registro', 'asc')
            ->get();


        $nota = $this->obtenerListaTratamiento($estancia);

        return Inertia::render('formularios/hojas-enfermerias/edit',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'hojaenfermeria' => $hojasenfermeria, 
            'medicamentos' => $medicamentos,
            'soluciones' => $soluciones,
            'sondas_cateters' => $sondas_cateters,
            'dataParaGraficas' => $dataParaGraficas,
            'catalogoEstudios' => $catalogoEstudios,
            'solicitudesAnteriores' => $solicitudesAnteriores,
            'medicos' => $medicos,
            'usuarios' => $usuarios,

            'nota' =>$nota,
            'checklistInicial' => $nota ? $nota->checklistItems->where('is_completed', true)->values() : [],

            'categoria_dietas' => $categoria_dietas,
            'vias_administracion' => $vias_administracion,
        ]);
    }

    /**
     * Actualiza la hoja de enfermería (Observaciones o Estado).
     *
     * @param  \Illuminate\Http\Request  
     * @param  \App\Models\HojaEnfermeria  
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(HojaEnfermeriaRequest $request, HojaEnfermeria $hojasenfermeria)
    {
        if ($hojasenfermeria->estado === 'Cerrado' && !$request->has('estado')) {
             return Redirect::back()->with('error', 'Esta hoja ya está cerrada y no puede ser modificada.');
        }

        $hojasenfermeria->update($request->validated());
        
        $message = 'Hoja de enfermería actualizada.';

        if ($request->has('estado')) {
            $message = '¡Hoja de enfermería cerrada exitosamente!';
        }
        
        return Redirect::back()->with('success', $message);
    }

    private function obtenerListaTratamiento(Estancia $estancia){
        $notaPostoperatoria = $estancia->notasPostoperatorias()->latest()->first();
        $notaEvolucion = $estancia->notasEvoluciones()->latest()->first();

        $nota = null;

        if ($notaPostoperatoria && $notaEvolucion) {
            $nota = $notaPostoperatoria->created_at > $notaEvolucion->created_at 
                    ? $notaPostoperatoria 
                    : $notaEvolucion;
        } elseif ($notaPostoperatoria) {
            $nota = $notaPostoperatoria;
        } else {
            $nota = $notaEvolucion;
        }

        if ($nota) {
            $nota->load('checklistItems');
        }
        
        return $nota;
    }


    public function generarPDF(HojaEnfermeria $hojasenfermeria)
    {
        $hojasenfermeria->load(
            'formularioInstancia.estancia.paciente',
            'hojaMedicamentos.aplicaciones',
            'hojaMedicamentos.productoServicio',
            'hojasTerapiaIV.detalleSoluciones',
            'formularioInstancia.user.credenciales',
            'formularioInstancia.user.colaborador_responsable.credenciales',
            'hojaSignos',
            'solicitudesEstudio.solicitudItems.catalogoEstudio',
            'sondasCateteres.productoServicio',
            'solicitudesDieta.dieta.categoriaDieta',
            'hojaEscalaValoraciones.valoracionDolor',
            'hojaRiesgoCaida',
            'hojaHabitusExterior',
            'hojaOxigenos.userInicio',
            'hojaOxigenos.userFin',
        );

        $headerData = [
            'historiaclinica' => $hojasenfermeria,
            'paciente' => $hojasenfermeria->formularioInstancia->estancia->paciente,
            'estancia' => $hojasenfermeria->formularioInstancia->estancia
        ];

        $viewData = [
            'notaData'=> $hojasenfermeria,
            'medico'=> $hojasenfermeria->formularioInstancia->user,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.hoja-enfermeria',
            $viewData,
            $headerData,
            'hoja-enfermeria-',
            $hojasenfermeria->formularioInstancia->estancia->id
        );

    }
}


