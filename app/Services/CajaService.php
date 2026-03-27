<?php

namespace App\Services;

use App\Models\Caja\SesionCaja;
use App\Models\Caja\MovimientoCaja;
use App\Models\Venta\Pago;
use App\Models\Caja\SolicitudTraspaso;
use App\Models\Caja\Caja;

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
        $estadoActual = $sesion->estado instanceof EstadoSesionCaja 
            ? $sesion->estado->value 
            : $sesion->estado;

        if ($estadoActual !== 'abierta') {
            throw new \Exception("No se pueden registrar movimientos en una caja cerrada.");
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
        $estadoActual = $sesion->estado instanceof EstadoSesionCaja 
            ? $sesion->estado->value 
            : $sesion->estado;

        if ($sesion->estado !== 'abierta') {
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

    public function solicitarTraspaso(int $cajaOrigenId, int $cajaDestinoId, float $montoSolicitado, string $concepto, int $userId)
    {
        return SolicitudTraspaso::create([
            'caja_origen_id' => $cajaOrigenId,   
            'caja_destino_id' => $cajaDestinoId, 
            'monto_solicitado' => $montoSolicitado,
            'concepto' => $concepto,
            'user_solicita_id' => $userId,
            'estado' => 'pendiente'
        ]);
    }

    public function responderTraspaso(SolicitudTraspaso $solicitud, bool $aprobar, float $montoAprobado, int $userId)
    {
        if ($solicitud->estado !== 'pendiente') {
            throw new Exception("Esta solicitud ya fue procesada anteriormente.");
        }

        return DB::transaction(function () use ($solicitud, $aprobar, $montoAprobado, $userId) {
            
            if (!$aprobar) {
                $solicitud->update([
                    'estado' => 'rechazada',
                    'user_aprueba_id' => $userId
                ]);
                return $solicitud;
            }

            $sesionOrigen = SesionCaja::where('caja_id', $solicitud->caja_origen_id)
                ->where('estado', 'abierta')
                ->first();

            $sesionDestino = SesionCaja::where('caja_id', $solicitud->caja_destino_id)
                ->where('estado', 'abierta')
                ->first();

            if (!$sesionOrigen) {
                throw new Exception("No se puede enviar el dinero: La caja de origen (Fondo/Bóveda) no tiene un turno abierto.");
            }
            if (!$sesionDestino) {
                throw new Exception("No se puede enviar el dinero: La caja destino cerró su turno antes de recibir la transferencia.");
            }

            $solicitud->update([
                'estado' => 'aprobada',
                'monto_aprobado' => $montoAprobado,
                'user_aprueba_id' => $userId
            ]);

            $this->registrarMovimiento(
                $sesionOrigen, 
                TipoMovimientoCaja::EGRESO,
                $montoAprobado, 
                "Traspaso autorizado a caja: {$solicitud->cajaDestino->nombre} (Ref: {$solicitud->id})", 
                $userId
            );
            $this->registrarMovimiento(
                $sesionDestino, 
                TipoMovimientoCaja::INGRESO, 
                $montoAprobado, 
                "Traspaso recibido de Caja ID: {$solicitud->caja_origen_id} (Ref: {$solicitud->id})", 
                $userId
            );
            return $solicitud;
        });
    }

    /**
     * La Caja toma dinero del Fondo directamente y alerta a Bóveda
     */    
    public function tomarDineroDeFondo(int $cajaOperativaId, float $monto, string $concepto, int $userId)
    {
        return DB::transaction(function () use ($cajaOperativaId, $monto, $concepto, $userId) {
            
            // Identificar quién es el fondo, y quien es la bóveda
            $fondo = Caja::where('tipo', 'fondo')->firstOrFail();
            $boveda = Caja::where('tipo', 'boveda')->firstOrFail();

            // Se buscan las sesiones abiertas
            $sesionCaja = SesionCaja::where('caja_id', $cajaOperativaId)->where('estado', 'abierta')->first();
            $sesionFondo = SesionCaja::where('caja_id', $fondo->id)->where('estado', 'abierta')->first();

            if (!$sesionCaja || !$sesionFondo) {
                throw new Exception("Error: La caja operativa o el fondo no tienen un turno abierto.");
            }

            // 3. MOVIMIENTO INMEDIATO: Le quitamos al Fondo y le damos a la Caja
            $this->registrarMovimiento(
                $sesionFondo, 
                TipoMovimientoCaja::EGRESO, 
                $monto, 
                "Retiro directo hacia caja operativa - concepto: $concepto", 
                $userId
            );

            $this->registrarMovimiento(
                $sesionCaja, 
                TipoMovimientoCaja::INGRESO, 
                $monto, 
                "Ingreso tomado del fondo - Concepto: $concepto", 
                $userId
            );

            // Se crea la solicitud para que la Bóveda reponga el Fondo
            return SolicitudTraspaso::create([
                'caja_origen_id' => $boveda->id, // Bóveda paga
                'caja_destino_id' => $fondo->id, // Fondo recibe
                'monto_solicitado' => $monto,
                'concepto' => "Reposición automática: La Caja " . $sesionCaja->caja->nombre . " tomó dinero del Fondo. ($concepto)",
                'user_solicita_id' => $userId,
                'estado' => 'pendiente'
            ]);
        });
    }
}