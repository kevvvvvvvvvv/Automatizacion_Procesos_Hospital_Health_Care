<?php

namespace App\Services;

use App\Models\Caja\SesionCaja;
use App\Models\Caja\MovimientoCaja;
use App\Models\Venta\Pago;
use App\Enums\EstadoSesionCaja;
use App\Enums\TipoMovimientoCaja;
use Illuminate\Support\Facades\DB;
use Exception;

class CajaService
{
    /**
     * Inicia un nuevo turno para un usuario en una caja específica.
     */
    public function abrirTurno(int $cajaId, int $userId, float $montoInicial): SesionCaja
    {
        $sesionAbierta = SesionCaja::where('user_id', $userId)
            ->where('estado', EstadoSesionCaja::ABIERTA)
            ->first();

        if ($sesionAbierta) {
            throw new Exception("El usuario ya tiene un turno abierto en la caja ID: {$sesionAbierta->caja_id}");
        }

        return SesionCaja::create([
            'caja_id' => $cajaId,
            'user_id' => $userId,
            'monto_inicial' => $montoInicial,
            'estado' => EstadoSesionCaja::ABIERTA,
            'fecha_apertura' => now(),
        ]);
    }

    /**
     * Registra entradas o salidas de dinero ajenas a una venta (ej. pago a proveedores).
     */
    public function registrarMovimiento(SesionCaja $sesion, TipoMovimientoCaja $tipo, float $monto, string $concepto, int $userId): MovimientoCaja
    {
        if ($sesion->estado !== EstadoSesionCaja::ABIERTA) {
            throw new Exception("No se pueden registrar movimientos en una caja cerrada.");
        }

        return DB::transaction(function () use ($sesion, $tipo, $monto, $concepto, $userId) {
            $movimiento = $sesion->movimientos()->create([
                'tipo' => $tipo,
                'monto' => $monto,
                'concepto' => $concepto,
                'user_id' => $userId,
            ]);

            if ($tipo === TipoMovimientoCaja::INGRESO) {
                $sesion->increment('total_ingresos_efectivo', $monto);
            } else {
                $sesion->increment('total_egresos_efectivo', $monto);
            }

            return $movimiento;
        });
    }

    /**
     * Vincula un pago de una venta al turno actual del cajero.
     */
    public function procesarPagoDeVenta(Pago $pago, SesionCaja $sesion, bool $esEfectivo): void
    {
        DB::transaction(function () use ($pago, $sesion, $esEfectivo) {
            $pago->update(['sesion_caja_id' => $sesion->id]);

            if ($esEfectivo) {
                $sesion->increment('total_ingresos_efectivo', $pago->monto);
            } else {
                $sesion->increment('total_otros_metodos', $pago->monto);
            }
        });
    }

    /**
     * Realiza el corte y cierra la sesión.
     */
    public function cerrarTurno(SesionCaja $sesion, float $montoDeclarado, array $desgloseFisico = []): SesionCaja
    {
        if ($sesion->estado !== EstadoSesionCaja::ABIERTA) {
            throw new Exception("La caja ya se encuentra cerrada.");
        }

        return DB::transaction(function () use ($sesion, $montoDeclarado, $desgloseFisico) {
            if (!empty($desgloseFisico)) {
                $sesion->desglosesEfectivo()->createMany($desgloseFisico);
            }
            
            $diferencia = $montoDeclarado - $sesion->monto_esperado;

            $sesion->update([
                'estado' => EstadoSesionCaja::CERRADA,
                'fecha_cierre' => now(),
                'monto_declarado' => $montoDeclarado,
                'sobrante_faltante' => $diferencia,
            ]);

            return $sesion;
        });
    }
}