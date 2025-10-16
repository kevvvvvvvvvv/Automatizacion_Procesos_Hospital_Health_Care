<?php

use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\FormularioHojaFrontalController;
use App\Http\Controllers\FormularioHistoriaClinicaController;
use App\Http\Controllers\FormularioInstanciaController;
use App\Http\Controllers\DoctorController; 
use App\Http\Controllers\ProductoServicioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\HistoryController;
use App\Models\History;
use App\Models\Paciente;
use App\Models\ProductoServicio;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('dashboard-healthcare');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard-healthcare');
    })->name('dashboard');
});
Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store');
Route::resource('habitaciones',HabitacionController::class)->middleware('auth');
Route::resource('producto-servicios',ProductoServicioController::class)->middleware('auth');
Route::resource('pacientes', PacienteController::class)->middleware('auth');
Route::resource('pacientes.estancias', EstanciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasfrontales', FormularioHojaFrontalController::class)->shallow()->parameters(['hojasfrontales' => 'hojaFrontal'])->middleware('auth');
Route::resource('pacientes.estancias.historiasclinicas', FormularioHistoriaClinicaController::class)->shallow()->middleware('auth');

Route::resource('doctores', DoctorController::class)->middleware('auth');  
Route::put('/doctores/{doctor}', [DoctorController::class, 'update'])->name('doctores.update');

Route::get('historiales',[HistoryController::class,'index'])->name('historiales.index');


Route::get('/hojasfrontales/{hojafrontal}/pdf', [FormularioHojaFrontalController::class, 'generarPDF'])
    ->name('hojasfrontales.pdf')
    ->middleware('auth');

Route::get('/historiasclinicas/{historiaclinica}/pdf', [FormularioHistoriaClinicaController::class, 'generarPDF'])
    ->name('hojasfrontales.pdf')
    ->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

