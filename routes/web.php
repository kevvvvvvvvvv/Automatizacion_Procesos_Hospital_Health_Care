<?php

use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\FormularioHojaFrontalController;
use App\Http\Controllers\FormularioInstanciaController;
use App\Http\Controllers\DoctorController; 
use App\Http\Controllers\ProductoServicioController;
use App\Http\Controllers\InterconsultaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FamiliarResponsableController;
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
Route::resource('pacientes.responsable', FamiliarResponsableController::class);
Route::resource('pacientes.estancias', EstanciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasfrontales', FormularioHojaFrontalController::class)->shallow()->middleware('auth');

Route::resource('doctores', DoctorController::class)->middleware('auth');  

Route::resource('pacientes.estancias.interconsulta', InterconsultaController::class)->parameters(['interconsulta' => 'interconsulta']);
Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
    ->parameters(['interconsultas' => 'interconsulta'])
    ->names('pacientes.estancias.interconsultas');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

