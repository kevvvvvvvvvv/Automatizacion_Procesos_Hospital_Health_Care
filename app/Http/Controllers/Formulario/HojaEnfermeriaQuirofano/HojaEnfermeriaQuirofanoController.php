<?php

namespace App\Http\Controllers\Formulario\HojaEnfermeriaQuirofano;

use App\Http\Controllers\Controller;
use App\Http\Requests\HojaEnfermeriaQuirofanoRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\HojaEnfermeriaQuirofano\HojaEnfermeriaQuirofano;
use App\Models\Inventario\CatalogoViaAdministracion;
use App\Models\Inventario\ProductoServicio;
use App\Models\User;
use App\Services\PdfGeneratorService;
use App\Services\VentaService;
use App\Models\Venta\Venta;

class HojaEnfermeriaQuirofanoController extends Controller  implements HasMiddleware
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

    public function show()
    {
        return Redirect::back()->with('error','La opción de mostrar no esta habilitada por el momento.');
    }

    public function create(Paciente $paciente, Estancia $estancia)
    {

        return Redirect::route('pacientes.estancias.hojasenfermeriasquirofanos.store',[
            $paciente->id,
            $estancia->id
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia)
    {
        DB::beginTransaction();
        try{ 
            
            $instancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_HOJA_ENFERMERIA_QUIROFANO,
                'user_id' => Auth::id(),
            ]);

            $hoja = HojaEnfermeriaQuirofano::create([
                'id' => $instancia->id,
                'estado' => 'Abierto',
            ]);

            DB::commit();
            return Redirect::route('hojasenfermeriasquirofanos.edit', $hoja->id);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear la hoja de enfermería en quirófano: ' . $e);
            return Redirect::back()->with('error','Error al crear la hoja de enfermería en quirófano.');
        }       
    }

    public function edit(HojaEnfermeriaQuirofano $hojasenfermeriasquirofano)
    {
        $hojasenfermeriasquirofano->load(
            'formularioInstancia.estancia.paciente',
            'hojaInsumosBasicos.productoServicio',
            'hojaOxigenos.userInicio',
            'hojaOxigenos.userFin',
            'personalEmpleados',
            'conteoMaterialQuirofano',
            'isquemias',
            'hojaSignos',
        );

        $users = User::all();
        $insumos = ProductoServicio::where('tipo','INSUMOS')->get();
        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->get();
        $vias_administacion = CatalogoViaAdministracion::all();

        return Inertia::render('formularios/hojas-enfermerias-quirofano/edit',[
            'paciente' => $hojasenfermeriasquirofano->formularioInstancia->estancia->paciente,
            'estancia' => $hojasenfermeriasquirofano->formularioInstancia->estancia,
            'hoja' => $hojasenfermeriasquirofano,
            'insumos' => $insumos,
            'users' => $users,
            'medicamentos' => $medicamentos,    
            'vias_administracion' => $vias_administacion,
        ]);
    }

    public function update(HojaEnfermeriaQuirofanoRequest $request,HojaEnfermeriaQuirofano $hojasenfermeriasquirofano)
    {
        $validatedData = $request->validated();
        try{
            $hojasenfermeriasquirofano->update([
                ...$validatedData
            ]);
            
            return Redirect::route('hojasenfermeriasquirofanos.edit', $hojasenfermeriasquirofano->id)->with('success','Se ha actualizado la hoja de enfermería en quirófano.');
        }catch(\Exception $e){
            Log::error('Error al actualizar la hoja de enfermería en quirófano: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al actualizar la hoja de enfermería en quirófano.');
        }

    }

    public function generarPDF(HojaEnfermeriaQuirofano $hojasenfermeriasquirofano)
    {
        $hojasenfermeriasquirofano->load(
            'formularioInstancia.estancia.paciente',
            'hojaInsumosBasicos.productoServicio',
            'hojaOxigenos.userInicio',
            'hojaOxigenos.userFin',
            'personalEmpleados',
            'hojaInsumosBasicos.productoServicio',
        );

        $headerData = [
            'historiaclinica' => $hojasenfermeriasquirofano,
            'paciente' => $hojasenfermeriasquirofano->formularioInstancia->estancia->paciente,
            'estancia' => $hojasenfermeriasquirofano->formularioInstancia->estancia,
        ];

        $viewData = [
            'notaData' => $hojasenfermeriasquirofano,
            'medico' => $hojasenfermeriasquirofano->formularioInstancia->user
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.hoja-enfermeria-quirofano',
            $viewData,
            $headerData,
            'hoja-enfermeria-quirofano',
            $hojasenfermeriasquirofano->formularioInstancia->estancia->id
        );

    }

    public function cerrarHoja(HojaEnfermeriaQuirofano $hojasenfermeriaquirofanos, VentaService $service)
    {
        DB::beginTransaction();
        try{
            $hojasenfermeriaquirofanos->update([
                'estado' => 'Cerrado'
            ]);

            $this->calcularVentas($hojasenfermeriaquirofanos, $service);

            DB::commit();
            return redirect()->route('estancias.show');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al cerrar la hoja de enfermería en quirófano: ' .$e->getMessage());
            $hojasenfermeriaquirofanos->load('formularioInstancia');
            return redirect()->route('estancias.show',[$hojasenfermeriaquirofanos->formularioInstancia->estancia_id])->with('success','Se ha cerrado la hoja de enfermería en quirófano.');
        }
    }

    private function calcularVentas(HojaEnfermeriaQuirofano $hoja, VentaService $service){
        try{
            $hoja->load('hojaInsumosBasicos');
            
            foreach ($hoja->hojaInsumosBasicos as $insumo){
                
                
                $itemParaVenta = [
                    'id' => ($insumo->producto_servicio_id ?? null),
                    'cantidad' => ($insumo->cantidad),
                    'tipo' => 'producto',
                ];

                $estanciaId =  $hoja->formularioInstancia->estancia_id;

                $ventaExistente = Venta::where('estancia_id', $estanciaId)
                                      ->where('estado', Venta::ESTADO_PENDIENTE)
                                      ->first();

                if ($ventaExistente) {
                    $service->addItemToVenta($ventaExistente, $itemParaVenta);
                } else {
                    $service->crearVenta([$itemParaVenta], $estanciaId, Auth::id());
                }
            }
        }catch(\Exception $e){
            \Log::error('Error en el cálculo de las ventas: ' . $e->getMessage());
            return Redirect::back()->with('error','Error en el cálculo de las ventas.');
        }
    }
}
