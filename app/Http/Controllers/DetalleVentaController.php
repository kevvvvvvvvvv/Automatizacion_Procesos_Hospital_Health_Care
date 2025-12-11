<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Venta;
use App\Models\DetalleVenta;

use Illuminate\Http\Request;
use inertia\Inertia;
use App\Services\VentaService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DetalleVentaController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar ventas', only: ['index', 'show']),
            new Middleware($permission . ':crear ventas', only: ['create', 'store']),
            new Middleware($permission . ':editar ventas', only: ['edit', 'update']),
            new Middleware($permission . ':eliminar ventas', only: ['destroy']),
        ];
    }


    public function index(Paciente $paciente, Estancia $estancia, Venta $venta)
    {
        $venta->load(['detalles.itemable']);

        return Inertia::render('ventas/detalles/index', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'venta' => $venta, 
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia, Venta $venta, VentaService $ventaService)
    {
        $data = $request->validate([
            'id' => 'required',
            'cantidad' => 'required|numeric|min:1',
            'tipo' => 'required|in:producto,estudio' 
        ]);

        $ventaService->addItemToVenta($venta, $data);

        return Redirect::back()->with('success', 'Ítem agregado correctamente.');
    }

    public function update(Request $request, DetalleVenta $detallesventa)
    {
        $validated = $request->validate([
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        $detallesventa->cantidad = $validated['cantidad'];
        $detallesventa->precio_unitario = $validated['precio_unitario'];
        $detallesventa->subtotal = $detallesventa->cantidad * $detallesventa->precio_unitario;
        $detallesventa->save();

        $venta = $detallesventa->venta;

        $detalles = $venta->detalles()->with('itemable')->get();

        $subtotalAcumulado = 0;
        $totalAcumulado = 0;

        foreach ($detalles as $detalle) {
            $subtotalAcumulado += $detalle->subtotal;
            $tasaIva = 0;

            $tasaIva = $detalle->itemable->iva ?? 0; 

            $totalLinea = $detalle->subtotal * (1 + ($tasaIva / 100));
            
            $totalAcumulado += $totalLinea;
        }
        $venta->update([
            'subtotal' => $subtotalAcumulado,
            'total' => $totalAcumulado, 
        ]);

        return Redirect::back()->with('success', 'Precio actualizado y recálculo de impuestos completado.');
    }

    public function destroy(DetalleVenta $detallesventa)
    {
        $venta = $detallesventa->venta;
        
        $detallesventa->delete();

        $detalles = $venta->detalles()->with('itemable')->get();
        $subtotalAcumulado = 0;
        $totalAcumulado = 0;

        foreach ($detalles as $detalle) {
            $subtotalAcumulado += $detalle->subtotal;
            $tasaIva = $detalle->itemable->iva ?? 0;
            $totalAcumulado += $detalle->subtotal * (1 + ($tasaIva / 100));
        }

        $venta->update([
            'subtotal' => $subtotalAcumulado,
            'total' => $totalAcumulado, 
        ]);

        return Redirect::back()->with('success', 'Ítem eliminado.');
    }
}
