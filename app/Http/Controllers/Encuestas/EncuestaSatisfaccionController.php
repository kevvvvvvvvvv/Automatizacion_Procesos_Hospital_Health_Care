<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estancia;
use Inertia\Inertia;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EncuestaSatisfaccionController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar hojas', only: ['index', 'show', 'generarPDF']),
            new Middleware($permission . ':crear hojas', only: ['create', 'store']),
            new Middleware($permission . ':eliminar hojas', only: ['destroy']),
        ];
    }


    public function create(Estancia $estancia){

        $estancia->load(
            'paciente'
        );

        return Inertia::render('formularios/encuestas-satisfacciones/create',[
            'estancia' => $estancia,
        ]);
    }

    public function store()
    {

    }
}
