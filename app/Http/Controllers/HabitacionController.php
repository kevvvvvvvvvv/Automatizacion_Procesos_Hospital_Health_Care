<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

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
    public function store(){
        Habitacion::create($request->validated());
        return Rendirect::route('habitaciones.index')
        ->with('Succes', 'Habitación resgitrada');

    }
    public function update(){

    }
    public function edit(){

    }
    public function index()
    {
        $habitaciones = Habitacion::with('estanciaActiva.paciente')->get();
        return Inertia::render('habitaciones/index',['habitaciones' => $habitaciones]);
    }
}
