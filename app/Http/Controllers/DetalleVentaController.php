<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use inertia\Inertia;
use App\Services\VentaService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Inventario\ProductoServicio;
use App\Models\Venta\Venta;
use App\Models\Venta\DetalleVenta;

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
        'itemable_type' => 'nullable|string',
    ]);


    $precioBaseSujeto = $validated['precio_unitario'] / (1 - ProductoServicio::comision_terminal);

    $detallesventa->cantidad = $validated['cantidad'];
    $detallesventa->precio_unitario = $precioBaseSujeto;
    $detallesventa->subtotal = $detallesventa->cantidad * $precioBaseSujeto;
    $detallesventa->save();

    $venta = $detallesventa->venta;

    $detalles = $venta->detalles()->with('itemable')->get();

    $subtotalGeneral = 0;
    $totalGeneral = 0;

    foreach ($detalles as $detalle) {
        $subtotalGeneral += $detalle->subtotal;

        $esRegistrado = $detalle->itemable_id !== null;
        
        $tasaIva = $esRegistrado ? 0.16 : ProductoServicio::IVA_Noregistrados;

        $totalLinea = $detalle->subtotal * (1 + $tasaIva);
        
        $totalGeneral += $totalLinea;
    }


    $venta->update([
        'subtotal' => $subtotalGeneral,
        'total' => $totalGeneral, 
    ]);

    return Redirect::back()->with('success', 'Venta actualizada: El 30% de IVA se aplicó al total de productos no registrados.');
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
