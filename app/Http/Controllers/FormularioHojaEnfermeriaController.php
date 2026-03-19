<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaEnfermeriaRequest;
use App\Models\Estudio\CatalogoEstudio;
use App\Models\Inventario\CatalogoViaAdministracion;
use App\Models\Cocina\CategoriaDieta;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use App\Models\Inventario\ProductoServicio;
use App\Models\Formulario\HojaEnfermeria\HojaSignos;
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
            new Middleware($permission . ':consultar hojas enfermerias', only: ['index', 'show', 'generarPDF']),
            new Middleware($permission . ':crear hojas enfermerias', only: ['create', 'store']),
            new Middleware($permission . ':eliminar hojas enfermerias', only: ['destroy']),
        ];
    }

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function show(HojaEnfermeria $hojasenfermeria)
    {
        $hojasenfermeria = $this->getRelaciones($hojasenfermeria);

        return Inertia::render('formularios/hojas-enfermerias/show', [
            'hoja' => $hojasenfermeria,
            'dataParaGraficas' => $this->formatoGraficas($hojasenfermeria),
        ]);

    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        $estancia->load('formularioInstancias.hojaEnfermeria');

/*         foreach ($estancia->formularioInstancias as $instancia) {
            if ($instancia->hojaEnfermeria && $instancia->hojaEnfermeria->estado == 'Abierto') {
                return Redirect::back()->with('error', 'Se tiene que cerrar la hoja de enfermería antes de crear una nueva');
            }
        } */

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
        $hojasenfermeria = $this->getRelaciones($hojasenfermeria);

        $estancia = $hojasenfermeria->formularioInstancia->estancia;
        $paciente = $hojasenfermeria->formularioInstancia->estancia->paciente;


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


        $nota = $this->obtenerListaTratamiento($estancia);

        return Inertia::render('formularios/hojas-enfermerias/edit',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'hojaenfermeria' => $hojasenfermeria, 
            'medicamentos' => $medicamentos,
            'soluciones' => $soluciones,
            'sondas_cateters' => $sondas_cateters,
            'dataParaGraficas' => $this->formatoGraficas($hojasenfermeria),
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
     * @param  \App\Models\HojaEnfermeria  dataParaGraficas
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
        $hojasenfermeria = $this->getRelaciones($hojasenfermeria);

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

    private function formatoGraficas(HojaEnfermeria $hojasenfermeria)
    {
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

        $dataParaGraficas = HojaSignos::select($columnasGraficas)
            ->where('hoja_enfermeria_id', $hojasenfermeria->id)
            ->orderBy('fecha_hora_registro', 'asc')
            ->get();

        return $dataParaGraficas;
    }

    private function getRelaciones(HojaEnfermeria $hoja)
    {
        $hoja->load(
            'formularioInstancia.user.credenciales',
            'formularioInstancia.user.colaborador_responsable.credenciales',
            'formularioInstancia.estancia.paciente', 
            'hojasTerapiaIV.detalleSoluciones',
            'hojaMedicamentos.productoServicio',
            'hojaMedicamentos.aplicaciones',
            'hojaOxigenos.userInicio',
            'hojaOxigenos.userFin',
            'hojaEscalaValoraciones.valoracionDolor',
            'hojaControlLiquidos',
            'hojaSignos',
            'solicitudesEstudio.solicitudItems.catalogoEstudio',
            'hojaRiesgoCaida',
            'solicitudesDieta.dieta.categoriaDieta',
            'hojaHabitusExterior',
        );

        $hoja = $this->getSondasCateteresActivos($hoja);
        $hoja = $this->getOxigenoActivo($hoja);

        return $hoja;
        
    }

    private function getSondasCateteresActivos(HojaEnfermeria $hoja)
    {
        $sondas = $hoja->sondas_activas;
        if ($sondas && $sondas->isNotEmpty()) {
            $sondas->load('productoServicio');
        }
        $hoja->setAttribute('sondas_activas_completas', $sondas);
        return $hoja;
    }

    private function getOxigenoActivo(HojaEnfermeria $hoja)
    {
        $oxigeno = $hoja->oxigeno_activo;
        if($oxigeno && $oxigeno->isNotEmpty()){
            $oxigeno->load(
                'userInicio',
                'userFin',
            );
        }

        $hoja->setAttribute('oxigeno_activo', $oxigeno); 
        return $hoja;
    }
}


