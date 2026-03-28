<?php

use App\Http\Controllers\BackupsRestauration\BackupsController;
use App\Http\Controllers\BackupsRestauration\RestaurationController;
use App\Http\Controllers\Inventario\ProductoServicioController;


use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\FormularioHojaFrontalController;
use App\Http\Controllers\FormularioHistoriaClinicaController;
use App\Http\Controllers\DoctorController; 

use App\Http\Controllers\InterconsultaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FamiliarResponsableController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\FormularioHojaEnfermeriaController;
use App\Http\Controllers\FormularioHojaMedicamentoController;
use App\Http\Controllers\HonorarioController;
use App\Http\Controllers\FormularioHojaTerapiaIVController;
use App\Http\Controllers\FormularioHojaSignosController;
use App\Http\Controllers\FarmaciaController;
use App\Http\Controllers\FormularioHojaSondaCateterController;
use App\Http\Controllers\FormularioHojaDietaController;
use App\Http\Controllers\HojaMedicamentoController;
use App\Http\Controllers\TrasladoController;
use App\Http\Controllers\AplicacionMedicamentoController;

use App\Http\Controllers\FormularioHojaInsumosBasicosController;
use App\Http\Controllers\FormularioNotaPostoperatorioController;
use App\Http\Controllers\HojaEnfemeriaQuirofanoController;
use App\Http\Controllers\SolicitudEstudioController;
use App\Http\Controllers\SolicitudEstudioPatologiaController;
use App\Http\Controllers\PreoperatoriaController;
use App\Http\Controllers\NotaUrgenciaController;
use App\Http\Controllers\NotasEgresoController;
use App\Http\Controllers\NotaEvolucionController;
use App\Http\Controllers\NotaPreAnestesicaController;
use App\Http\Controllers\NotaPostanestesicaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FormularioHojaOxigenoController;
use App\Http\Controllers\ConsentimientoController;
use App\Http\Controllers\ReservacionController;
use App\Http\Controllers\ReservacionQuirofanoController;
use App\Http\Controllers\PersonalEmpleadoController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\DietaController;
use App\Http\Controllers\FormularioHojaHabitusExteriorController;
use App\Http\Controllers\FormularioHojaRiesgoCaidaController;
use App\Http\Controllers\HojaControlLiquidoController;
use App\Http\Controllers\HojaEscalaValoracionController;

use App\Http\Controllers\Caja\CajaController;
use App\Http\Controllers\Caja\ContaduriaController;
use App\Http\Controllers\Caja\TraspasoController;

use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LigaFutbolController;
use App\Http\Controllers\Encuestas\EncuestaSatisfaccionController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\EncuestaPersonalController;
use App\Http\Controllers\ReporteInterconsultaController;
use App\Http\Controllers\ReporteConcienciaController;
use App\Http\Controllers\ReporteSignosController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\ResumenMedicoController;


use App\Http\Controllers\ReporteEstanciaController;
use App\Models\HojaContolLiquido;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\NotificacionController;

Route::get('/', function () {
    return Inertia::render('auth/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard-healthcare');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('dashboard-reporte', function (){
        return Inertia::render('dashboard-reportes');
    })->name('dashboard-reporte');
});

//Reportes 
// REPORTE DE TIPO DE ESTANCIA
Route::get('/reportes/tipo-estancia', [ReporteEstanciaController::class, 'showReporteEstancia'])
    ->name('reporte.estancias.show')
    ->middleware('auth'); 

Route::get('/reportes/tipo-estancia/generacionPDF', [ReporteEstanciaController::class, 'descargarReporteEstanciaPdf'])
    ->name('reporte.estancias.pdf')
    ->middleware('auth');

    // REPORTE DE MOTIVOS DE INTERCONSULTA
Route::get('/reportes/motivos-frecuentes', [ReporteInterconsultaController::class, 'showFrecuenciaMotivos'])
    ->name('reporte.motivos.show')
    ->middleware('auth');

Route::get('/reportes/motivos-frecuentes/pdf', [ReporteInterconsultaController::class, 'descargarPdfMotivos'])
    ->name('reporte.motivos.pdf')
    ->middleware('auth');

    // REPORTE DE ESCALAS DE VALORACIÓN
Route::get('/reportes/escalas-valoracion', [ReporteConcienciaController::class, 'showReporteEscalas'])
    ->name('reporte.escalas.show')
    ->middleware('auth');

Route::get('/reportes/escalas-valoracion/pdf', [ReporteConcienciaController::class, 'descargarPdfEscalas'])
    ->name('reporte.escalas.pdf')
    ->middleware('auth');

// REPORTE UNIFICADO DE SIGNOS VITALES (FC)
Route::get('/reportes/frecuencia-cardiaca', [ReporteSignosController::class, 'showFrecuenciaCardiaca'])
    ->name('reporte.fc.show')
    ->middleware('auth');

Route::get('/reportes/frecuencia-cardiaca/pdf', [ReporteSignosController::class, 'descargarPdfFrecuencia'])
    ->name('reporte.fc.pdf')
    ->middleware('auth');

// Ruta genérica para recetas médicas
Route::get('/receta/pdf/{tipo}/{id}', [RecetaController::class, 'generar'])
    ->name('receta.pdf')
    ->middleware('auth');  

Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store')->middleware('auth');
Route::resource('habitaciones', HabitacionController::class)->middleware('auth');
Route::resource('producto-servicios', ProductoServicioController::class)->middleware('auth');
Route::resource('pacientes', PacienteController::class)->middleware('auth');
Route::resource('doctores', DoctorController::class)->middleware('auth');  
Route::resource('reservaciones', ReservacionController::class)->middleware('auth');
Route::resource('quirofanos', ReservacionQuirofanoController::class)->middleware('auth');
Route::post('/reservaciones/{reservacione}/pagar',[ReservacionController::class,'pagar'])->middleware('auth');
Route::resource('dietas',DietaController::class)->middleware('auth');
Route::resource('mantenimiento', MantenimientoController::class)->middleware('auth');


Route::resource('respaldo', BackupsController::class)->middleware('auth');
Route::get('respaldo/{backup}/download', [BackupsController::class, 'download'])->name('bd.respaldo.download')->middleware('auth');
Route::resource('pacientes.estancias.paquetes', PaqueteController::class)->shallow()->middleware('auth');

Route::resource('pacientes.responsable', FamiliarResponsableController::class)->middleware('auth');
Route::resource('pacientes.estancias', EstanciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasfrontales', FormularioHojaFrontalController::class)->shallow()->parameters(['hojasfrontales' => 'hojaFrontal'])->middleware('auth');
Route::resource('pacientes.estancias.historiasclinicas', FormularioHistoriaClinicaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasenfermerias',FormularioHojaEnfermeriaController::class)->shallow()-> middleware('auth');
Route::resource('pacientes.estancias.ventas', VentaController::class)->shallow()->middleware('auth');
Route::post('/ventas/{venta}/pagar', [VentaController::class, 'registrarPago'])->middleware('auth')->name('ventas.pagar');
Route::resource('pacientes.estancias.ventas.detallesventas',DetalleVentaController::class)->shallow()->middleware ('auth');
Route::resource('pacientes.estancias.interconsultas.honorarios', HonorarioController::class)->shallow();
Route::resource('pacientes.estancias.traslados', TrasladoController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.preoperatorias', PreoperatoriaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notasurgencias', NotaUrgenciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notaspostanestesicas',NotaPostanestesicaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notaspostoperatorias', FormularioNotaPostoperatorioController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notasegresos', NotasEgresoController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notasevoluciones', NotaEvolucionController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notaspreanestesicas', NotaPreAnestesicaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasenfermeriasquirofanos',HojaEnfemeriaQuirofanoController::class)->shallow()->middleware('auth');
Route::put('/hojasenfermeriasquirofanos/{hojasenfermeriaquirofanos}/cerrraHoja',[HojaEnfemeriaQuirofanoController::class, 'cerrarHoja'])->name('hojasenfermeriasquirofanos.cerrarHoja')->middleware('auth');

Route::resource('paciente.estancias.resumenmedico', ResumenMedicoController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.consentimientos', ConsentimientoController::class)->shallow()->middleware('auth');
Route::resource('estancias.encuesta-satisfaccions', EncuestaSatisfaccionController::class)->shallow()->middleware('auth');
Route::resource('notificaciones', NotificacionController::class)->shallow()->middleware('auth');
Route::resource('estancias.encuestapersonal', EncuestaPersonalController::class)->shallow()->middleware('auth');


Route::post('/checklist/toggle', [ChecklistController::class, 'toggle'])->name('checklist.toggle')->middleware('auth');

Route::post('/pacientes/{paciente}/estancias/{estancia}/consentimientos', [ConsentimientoController::class, 'store'])->name('consentimientos.store')->middleware('auth');

Route::post('hojasterapiasiv/{hojasenfermeria}',[FormularioHojaTerapiaIVController::class,'store'])->name('hojasterapiasiv.store')->middleware('auth');
Route::patch('hojasterapiasiv/{hojasenfermeria}/{hojasterapiasiv}',[FormularioHojaTerapiaIVController::class,'update'])->name('hojasterapiasiv.update')->middleware('auth');

Route::get('solicitudes-dietas',[FormularioHojaDietaController::class,'index'])->name('solicitudes-dietas.index')->middleware('auth');
Route::post('solicitudes-dietas/{hojasenfermeria}',[FormularioHojaDietaController::class,'store'])->name('hojasenfermerias.solicitudes-dietas.store')->middleware('auth');
Route::get('solicitudes-dietas/{estancia}',[FormularioHojaDietaController::class, 'show'])->name('solicitudes-dietas.show')->middleware('auth');
Route::put('solicitudes-dietas/{solicitud_dieta}',[FormularioHojaDietaController::class, 'update'])->name('solicitudes-dietas.update')->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::prefix('pacientes/{paciente}/estancias/{estancia}')->group(function () {
    Route::get('notasegresos/create', [NotasEgresoController::class, 'create'])->name('pacientes.estancias.notasegresos.create');
    Route::post('notasegresos', [NotasEgresoController::class, 'store'])->name('pacientes.estancias.notasegresos.store');
    Route::get('notasegresos/{notaEgreso}', [NotaPreAnestesicaController::class, 'show'])->name('pacientes.estancias.notasegresos.show');
}) ->middleware('auth');

Route::post('hojasterapiasiv/{hojasenfermeria}',[FormularioHojaTerapiaIVController::class,'store'])->name('hojasterapiasiv.store')->middleware('auth');
Route::patch('hojasterapiasiv/{hojasenfermeria}/{hojasterapiasiv}',[FormularioHojaTerapiaIVController::class,'update'])->name('hojasterapiasiv.update')->middleware('auth');

Route::post('hojasmedicamentos/{hojasenfermeria}',[FormularioHojaMedicamentoController::class, 'store'])->name('hojasmedicamentos.store')->middleware('auth');
Route::patch('hojasmedicamentos/{hojasenfermeria}/{hojasmedicamento}',[FormularioHojaMedicamentoController::class, 'update'])->name('hojasmedicamentos.update')->middleware('auth');

Route::post('hojas-oxigenos', [FormularioHojaOxigenoController::class, 'store'])->name('hojasoxigenos.store')->middleware('auth');
Route::patch('hojas-oxigenos/{hojasoxigeno}', [FormularioHojaOxigenoController::class, 'update'])->name('hojasoxigenos.update')->middleware('auth');

Route::post('hojas-riesgo-caidas/{hojasenfermeria}',[FormularioHojaRiesgoCaidaController::class, 'store'])->name('hojas-riesgo-caidas.store')->middleware('auth');

Route::post('hojas-habitus-exterior/{hojasenfermeria}', [FormularioHojaHabitusExteriorController::class,'store'])->name('hojas-habitus-exterior.store')->middleware('auth');




Route::post('/notificaciones/marcar-leidas', [NotificacionController::class, 'markAllAsRead'])->name('notificaciones.read');
//Rutas Hoja de enfermeria en quirofano
Route::post('hojasinsumosbasicos/{hojasenfermeriasquirofano}', [FormularioHojaInsumosBasicosController::class, 'store'])->name('hojasinsumosbasicos.store')->middleware('auth');
Route::patch('hojasinsumosbasicos/{hojasinsumosbasico}', [FormularioHojaInsumosBasicosController::class, 'update'])->name('hojasinsumosbasicos.update')->middleware('auth');
Route::delete('hojasinsumosbasicos/{hojasinsumosbasico}', [FormularioHojaInsumosBasicosController::class, 'delete'])->name('hojasinsumosbasicos.destroy')->middleware('auth');

Route::get('/pacientes/{paciente}/estancias/{estancia}/notas-urgencias/{notaUrgencia}',[NotaUrgenciaController::class, 'show'])->name('pacientes.estancias.notasurgencias.show')->middleware('auth');


Route::post('hojassignos/{hojasenfermeria}',[FormularioHojaSignosController::class, 'store'])->name('hojassignos.store')->middleware('auth');
Route::post('hojas-control-liquidos/{hojasenfermeria}',[HojaControlLiquidoController::class, 'store'])->name('hojas-control-liquidos.store')->middleware('auth');
Route::post('hojas-escalas-valoracion/{hojasenfermeria}',[HojaEscalaValoracionController::class, 'store'])->name('hojas-escalas-valoracion.store')->middleware('auth');

Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)->shallow()->parameters(['interconsultas' => 'interconsulta'])->middleware('auth');
Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)->shallow()->parameters(['honorarios' => 'honorario','interconsultas' => 'interconsulta'])->middleware('auth');
Route::get('pacientes/{paciente}/estancias/{estancia}/interconsultas/{interconsulta}', [InterconsultaController::class, 'show'])->name('pacientes.estancias.interconsultas.show')->middleware('auth');

Route::post('hojassignos/{hojasenfermeria}',[FormularioHojaSignosController::class, 'store'])->name('hojassignos.store')->middleware('auth');

Route::post('hojassondascateters/{hojasenfermeria}',[FormularioHojaSondaCateterController::class, 'store'])->name('hojassondascateters.store')->middleware('auth');
Route::patch('hojassondascateters/{hojasenfermeria}/{hojassondascateter}',[FormularioHojaSondaCateterController::class, 'update'])->name('hojassondascateters.update')->middleware('auth');
Route::post('hoja-medicamentos/{hoja_medicamento}/aplicaciones', [AplicacionMedicamentoController::class, 'store'])->name('aplicaciones.store')->middleware('auth');

// Rutas para estudios y patologías
Route::post('solicitudes-patologias/{estancia}', [SolicitudEstudioPatologiaController::class, 'store'])->name('solicitudes-patologias.store')->middleware('auth');
Route::post('solicitudes-patologias/{solicitud-patologia}/edit', [SolicitudEstudioPatologiaController::class, 'edit'])->name('solicitudes-patologias.edit')->middleware('auth');
Route::put('solicitudes-patologias/{estancia}', [SolicitudEstudioPatologiaController::class, 'update'])->name('solicitudes-patologias.update')->middleware('auth');
Route::post('solicitudes-patologias/{solicitud-patologia}/show', [SolicitudEstudioPatologiaController::class, 'show'])->name('solicitudes-patologias.show')->middleware('auth');

// Solicitud de estudios
//Route::post('solicitudes-estudios/{estancia}',[SolicitudEstudioController::class, 'store'])->name('solicitudes-estudios.store');

Route::post('personal-empleados', [PersonalEmpleadoController::class, 'store'])->middleware('auth')->name('personal-empleados.store');
Route::delete('personal-empleados/{personalEmpleado}', [PersonalEmpleadoController::class, 'destroy'])->middleware('auth')->name('personal-empleados.destroy');

Route::resource('estancia.solicitudes-estudios', SolicitudEstudioController::class)->shallow()->parameters(['estancia'=>'estancia'])->middleware('auth');

// liga de furbol
Route::get('/liga-futbol/pdf', [LigaFutbolController::class, 'generarPdf'])
->name('liga-futbol.pdf')
->middleware('auth');

//PDFs
Route::get('/hojasfrontales/{hojafrontal}/pdf', [FormularioHojaFrontalController::class, 'generarPDF'])
    ->name('hojasfrontales.pdf')
    ->middleware('auth');

Route::get('/historiasclinicas/{historiaclinica}/pdf', [FormularioHistoriaClinicaController::class, 'generarPDF'])
    ->name('historiasclinicas.pdf')
    ->middleware('auth');

Route::get('/interconsultas/{interconsulta}/pdf', [InterconsultaController::class, 'generarPDF'])
    ->name('interconsultas.pdf')
    ->middleware('auth');

Route::get('/traslados/{traslado}/pdf', [TrasladoController::class, 'generarPDF'])
    ->name('traslados.pdf')
    ->middleware('auth');

Route::get('/preoperatorias/{preoperatoria}/pdf', [PreoperatoriaController::class, 'generarPDF'])
    ->name('preoperatorias.pdf')
    ->middleware('auth');

Route::get('/hojasenfermerias/{hojasenfermeria}/pdf', [FormularioHojaEnfermeriaController::class, 'generarPDF'])
    ->name('hojasenfermerias.pdf')
    ->middleware('auth');

Route::get('/traslados/{traslado}/pdf', [TrasladoController::class, 'generarPDF'])
    ->name('traslados.pdf')
    ->middleware('auth');

Route::get('/notaspostoperatorias/{notaspostoperatoria}/pdf', [FormularioNotaPostoperatorioController::class, 'generarPDF'])
    ->name('notaspostoperatorias.pdf')
    ->middleware('auth');

Route::get('/notasurgencias/{notasurgencia}/pdf', [NotaUrgenciaController::class, 'generarPDF'])
->name('notasurgencias.pdf')
->middleware('auth');

Route::get('/notasegresos/{notasegreso}/pdf', [NotasEgresoController::class, 'generarPDF'])
    ->name('notasegresos.pdf')
    ->middleware('auth');


Route::get('/solicitudes-patologias/{solicitudespatologia}/pdf', [SolicitudEstudioPatologiaController::class, 'generarPDF'])
    ->name('solicitudes-patologias.pdf')
    ->middleware('auth');

Route::get('/notaspreanestesicas/{notaspreanestesica}/pdf',[NotaPreAnestesicaController::class, 'generarPDF'])
    ->name('notaspreanestesicas.pdf')
    ->middleware('auth');
    
Route::get('/notaspostanestesicas/{notaspostanestesica}/pdf', [NotaPostanestesicaController::class, 'generarPDF'])
    ->name('notaspostanestesicas.pdf')
    ->middleware('auth');

Route::get('/notasevoluciones/{notasevolucione}/pdf', [NotaEvolucionController::class, 'generarPDf'])
    ->name('notasevoluciones.pdf')
    ->middleware('auth');

Route::get('/hojasenfermeriasquirofanos/{hojasenfermeriasquirofano}/pdf', [HojaEnfemeriaQuirofanoController::class, 'generarPDF'])
    ->name('hojasenfermeriasquirofanos.pdf')
    ->middleware('auth');

Route::get('/solicitudes-estudios/{solicitudes_estudio}/pdf', [SolicitudEstudioController::class, 'generarPDf'])
    ->name('solicitudes-estudios.pdf')
    ->middleware('auth');

Route::get('/consentimientos/pdf/{file}', [ConsentimientoController::class, 'generarPDF'])
    ->where('file', '.*')
    ->name('consentimientos.pdf')
    ->middleware('auth');
Route::get('/encuesta-satisfaccions/{encuesta-satisfaccions}/pdf', [EncuestaSatisfaccionController::class, 'generarPDF'])
    ->name('encuesta-satisfaccions.pdf')
    ->middleware('auth');

Route::get('/encuestapersonal/{encuestapersonal}/pdf', [EncuestaPersonalController::class, 'generarPDF'])
    ->name('encuestapersonal.pdf')
    ->middleware('auth');

// Farmacia
Route::get('farmacia/solicitudes-medicamentos/{hojasenfermeria}', [FarmaciaController::class, 'show'])
    ->name('solicitudes-medicamentos.show')
    ->middleware('auth');

Route::get('farmacia/solicitudes-medicamentos', [FarmaciaController::class, 'index'])->name('solicitudes-medicamentos.index')->middleware('auth');


Route::patch('/medicamentos/{medicamento}/actualizar-estado', [HojaMedicamentoController::class, 'actualizarEstado'])
    ->name('medicamentos.actualizar-estado')
    ->middleware('auth');

// Caja
Route::middleware('auth:sanctum')->prefix('caja')->group(function () {
    Route::get('/caja',[CajaController::class, 'index'])->name('caja.index');
    Route::get('/turno-actual', [CajaController::class, 'turnoActual'])->name('caja-turno-actual');
    Route::post('/abrir', [CajaController::class, 'abrirTurno'])->name('caja-abrir-turno');
    Route::post('/movimiento', [CajaController::class, 'registrarMovimiento'])->name('caja-movimiento');
    Route::post('/cerrar', [CajaController::class, 'cerrarTurno'])->name('caja-cerrar');
    Route::post('/traspasos/solicitar', [TraspasoController::class, 'solicitar'])->name('traspasos.solicitar');
    Route::post('/traspasos/{solicitud}/responder', [TraspasoController::class, 'responder'])->name('traspasos.responder');
    Route::post('/traspasos/enviar-boveda', [TraspasoController::class, 'enviarABoveda'])->name('traspasos.enviarABoveda');
});

//Contador
Route::get('/tesoreria/boveda', [ContaduriaController::class, 'index'])->name('contaduria.index')->middleware('auth');
Route::post('/tesoreria/boveda/gasto', [ContaduriaController::class, 'registrarGasto'])->name('boveda.registrarGasto');

// Notificaciones
Route::post('/notifications/mark-all-as-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.mark-all-as-read')->middleware('auth');

Route::post('/notifications/{id}/mark-as-read', function ($id) {
    $notification = Auth::user()->notifications()->where('id', $id)->first();
    if ($notification) {
        $notification->markAsRead();
    }

    return redirect()->back();
})->name('notifications.mark-as-read')->middleware('auth');

// Historial
Route::get('/historial', [HistoryController::class, 'index'])->name('historiales.index')->middleware('auth');
Route::get ('/rerservacion/reserva', [ReservacionController::class, 'reserva'])->name('rerservaciones.reserva')->middleware('auth');


//Restauración de la base de datos  
Route::get('/bd/respaldo/restauracion/', [RestaurationController::class, 'showView'])
    ->name('bd.restauracion'); 

Route::get('/bd/respaldo/restauracion', [RestaurationController::class, 'showView'])
    ->name('bd.restauracion'); 

Route::post('/bd/respaldo/restauracion', [RestaurationController::class, 'restore'])
    ->name('bd.restauracion.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
      