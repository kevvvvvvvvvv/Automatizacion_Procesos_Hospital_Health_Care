<?php

namespace App\Http\Controllers;

use App\Models\ProductoServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoServicioController extends Controller
{
    public function index()
    {
        $productoServicios = ProductoServicio::all(); 

        return Inertia::render('producto-servicios/index', [
            'productoServicios' => $productoServicios 
        ]);
    }
}
