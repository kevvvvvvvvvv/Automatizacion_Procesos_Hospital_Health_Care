<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Redirect;
use App\Http\Requests\HabitacionRequest;

class HabitacionController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar habitaciones', only: ['index', 'show']),
            new Middleware($permission . ':crear habitaciones', only: ['create', 'store']),
            new Middleware($permission . ':editar habitaciones', only: ['edit', 'update']),
            new Middleware($permission . ':eliminar habitaciones', only: ['destroy']),
        ];
    }
    public function create(){
        return Inertia::render('habitaciones/create', [
            'habitacion' => null,
        ]);
    }
    public function store(HabitacionRequest $request){
        Habitacion::create($request->validated());
        return Redirect::route('habitaciones.index')
        ->with('Succes', 'Habitación resgitrada');

    }
    public function update(HabitacionRequest $request, Habitacion $habitacione){
        $habitacione->update($request->validated());

        return Redirect::route('habitaciones.index')
        ->with('Success', 'Habitacion actualizada');
    }
    public function edit(Habitacion $habitacione){
        return Inertia::render('habitaciones/create', [
            'habitacion' => $habitacione,
        ]);
    }
    public function index()
    {
        $habitaciones = Habitacion::with('estanciaActiva.paciente')->get();
        return Inertia::render('habitaciones/index',['habitaciones' => $habitaciones]);
    }
}
