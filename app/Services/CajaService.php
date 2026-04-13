<?php

namespace App\Services;

use App\Models\Caja\SesionCaja;
use App\Models\Caja\MovimientoCaja;
use App\Models\Venta\Pago;
use App\Models\Caja\SolicitudTraspaso;
use App\Models\Caja\Caja;
use App\Models\User;

use App\Enums\EstadoSesionCaja;
use App\Enums\MetodoPago as EnumsMetodoPago;
use App\Enums\TipoMovimientoCaja;
use App\Models\Venta\MetodoPago;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Caja\DiscrepanciaSesion;

use App\Events\Caja\NuevoMovimientoCaja;


class CajaService
{
    /**
     * Inicia un nuevo turno para un usuario en una caja específica.
     */
    public function abrirTurno(int $cajaId, int $userId, float $montoInicial): SesionCaja
    {
        // 1. Evitar doble sesión abierta para el mismo usuario
        $sesionAbierta = SesionCaja::where('user_id', $userId)
            ->where('estado', EstadoSesionCaja::ABIERTA)
            ->first();

        if ($sesionAbierta) {
            throw new Exception("El usuario ya tiene un turno abierto en la caja ID: {$sesionAbierta->caja_id}");
        }

        // 2. Buscar la última sesión CERRADA de esta caja para comparar saldos
        $ultimaSesion = SesionCaja::where('caja_id', $cajaId)
            ->where('estado', EstadoSesionCaja::CERRADA)
            ->latest('fecha_cierre')
            ->first();

        $diferenciaApertura = 0;

        if ($ultimaSesion) {
            // Dinero que debió quedar: (Lo que declaró el anterior - lo que mandó a contaduría)
            $saldoEsperado = $ultimaSesion->monto_declarado - ($ultimaSesion->monto_enviado_contaduria ?? 0);
            
            $diferenciaApertura = $montoInicial - $saldoEsperado;

            // 3. Si hay diferencia, notificamos de inmediato
            if ($diferenciaApertura != 0) {
                $usuarioEntrante = User::find($userId);
                $this->notificarDiscrepanciaApertura($ultimaSesion, $usuarioEntrante, $diferenciaApertura);
            }
        }

        // 4. Crear la nueva sesión guardando el rastro de la diferencia
        return SesionCaja::create([
            'caja_id' => $cajaId,
            'user_id' => $userId,
            'monto_inicial' => $montoInicial,
            'estado' => EstadoSesionCaja::ABIERTA,
            'fecha_apertura' => now(),
            // Es vital guardar esto para que el contador lo vea en su tabla
            'sobrante_faltante' => $diferenciaApertura, 
        ]);
    }

    /**
     * Registra entradas o salidas de dinero ajenas a una venta (ej. pago a proveedores).
     */
    public function registrarMovimiento(
        SesionCaja $sesion, 
        TipoMovimientoCaja $tipo, 
        float $monto, 
        string $concepto, 
        int $userId,
        ?string $descripcion = null,
        ?string $nombre_paciente=null,
        ?int $metodoPagoId = 1, //Metodo de pago efectivo 
        ?string $area = null,
        bool $factura = false,
    ): MovimientoCaja
    {
        $estadoActual = $sesion->estado instanceof EstadoSesionCaja 
            ? $sesion->estado->value 
            : $sesion->estado;

        if ($estadoActual !== 'abierta') {
            throw new \Exception("No se pueden registrar movimientos en una caja cerrada.");
        }

        return DB::transaction(function () use ($sesion, $tipo, $monto, $area, $concepto, $metodoPagoId ,$userId, $descripcion, $nombre_paciente, $factura) {
            $movimiento = $sesion->movimientos()->create([
                'tipo' => $tipo,
                'monto' => $monto,
                'area' => $area,
                'concepto' => $concepto,
                'descripcion' => $descripcion,
                'nombre_paciente' =>$nombre_paciente,
                'metodo_pago_id' => $metodoPagoId,
                'user_id' => $userId,
                'factura' => $factura
            ]);
            
            if($metodoPagoId == 1){
                if ($tipo === TipoMovimientoCaja::INGRESO) {
                    //Solo afectar si el metodo de pago es efectivo
                    
                    $sesion->increment('total_ingresos_efectivo', $monto);
                } else {
                    
                    $sesion->increment('total_egresos_efectivo', $monto);
                }
            }

            broadcast(new NuevoMovimientoCaja($sesion->caja_id));

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
    public function cerrarTurno(SesionCaja $sesion, float $montoDeclarado, float $montoEnviadoContaduria,array $desgloseFisico = []): SesionCaja
    {
        $estadoActual = $sesion->estado instanceof EstadoSesionCaja 
            ? $sesion->estado->value 
            : $sesion->estado;

        if ($sesion->estado !== 'abierta') {
            throw new Exception("La caja ya se encuentra cerrada.");
        }

        return DB::transaction(function () use ($sesion, $montoDeclarado, $desgloseFisico, $montoEnviadoContaduria) {
            if (!empty($desgloseFisico)) {
                $sesion->desglosesEfectivo()->createMany($desgloseFisico);
            }
            
            
            $diferencia = $montoDeclarado - $sesion->monto_esperado;

            $sesion->update([
                'fecha_cierre' => now(),
                'monto_enviado_contaduria' => $montoEnviadoContaduria,
                'monto_declarado' => $montoDeclarado,
                'sobrante_faltante' => $diferencia,
            ]);

            $diferencia = $sesion->monto_declarado - $sesion->monto_esperado;

            // Cierre de caja y realizar el movimiento
            $this->registrarMovimiento(
                $sesion,
                TipoMovimientoCaja::EGRESO,
                $montoEnviadoContaduria,
                'Cierre de caja - Traspaso a Contaduría',
                Auth::id(),
            );

            $sesionBoveda = SesionCaja::whereHas('caja', function($query) {
                    $query->where('tipo', 'boveda'); 
                })
                ->where('estado', 'abierta')
                ->first();

            if ($sesionBoveda) {
                $this->registrarMovimiento(
                    $sesionBoveda,
                    TipoMovimientoCaja::INGRESO,
                    $montoEnviadoContaduria,
                    "Recepción de efectivo: {$sesion->caja->nombre} - Cajero: {$sesion->user?->nombre_completo}",
                    Auth::id(),
                );

            } else {
                throw new Exception("No hay una sesión de Bóveda abierta para recibir el dinero.");
            }

            $sesion->update([
                'estado' => EstadoSesionCaja::CERRADA,
            ]);

            if ($diferencia != 0) {
                $this->notificarDiscrepanciaAContador($sesion, $diferencia);
            }

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
            $boveda = Caja::where('tipo', 'boveda')->firstOrFail();
            $esEnvioABoveda = $solicitud->caja_destino_id === $boveda->id;

            if (!$aprobar) {
                $solicitud->update([
                    'estado' => 'rechazada',
                    'user_aprueba_id' => $userId
                ]);

                if ($esEnvioABoveda) {
                    $sesionOrigen = SesionCaja::where('caja_id', $solicitud->caja_origen_id)->where('estado', 'abierta')->first();
                    if ($sesionOrigen) {
                        $this->registrarMovimiento(
                            $sesionOrigen, 
                            TipoMovimientoCaja::INGRESO,
                            $solicitud->monto_solicitado, 
                            "Devolución: Contaduría rechazó el envío de efectivo (Ref: {$solicitud->id})", 
                            $userId
                        );
                    }
                }
                return $solicitud;
            }

            //Si el contador aprueba
            $sesionOrigen = SesionCaja::where('caja_id', $solicitud->caja_origen_id)->where('estado', 'abierta')->first();
            $sesionDestino = SesionCaja::where('caja_id', $solicitud->caja_destino_id)->where('estado', 'abierta')->first();

            if (!$sesionDestino) {
                throw new Exception("No se puede enviar el dinero: La caja destino cerró su turno antes de recibir la transferencia.");
            }

            $solicitud->update([
                'estado' => 'aprobada',
                'monto_aprobado' => $montoAprobado,
                'user_aprueba_id' => $userId
            ]);

            if ($esEnvioABoveda) {
                $this->registrarMovimiento(
                    $sesionDestino, 
                    TipoMovimientoCaja::INGRESO, 
                    $montoAprobado, 
                    "Recepción de corte/efectivo de Caja ID: {$solicitud->caja_origen_id} (Ref: {$solicitud->id})", 
                    $userId
                );

                if ($montoAprobado < $solicitud->monto_solicitado && $sesionOrigen) {
                    $diferencia = $solicitud->monto_solicitado - $montoAprobado;
                    $this->registrarMovimiento(
                        $sesionOrigen,
                        TipoMovimientoCaja::INGRESO,
                        $diferencia,
                        "Ajuste automático: Contaduría recibió un monto menor al enviado. (Ref: {$solicitud->id})",
                        $userId
                    );
                }

            } else {
                
                if (!$sesionOrigen) {
                    throw new Exception("No se puede enviar el dinero: La caja de origen no tiene un turno abierto.");
                }

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
            }

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

    /**
     * El Cajero envía su corte/exceso de efectivo a Contaduría (Bóveda)
     */
    public function enviarDineroABoveda(int $cajaOperativaId, float $monto, string $concepto, int $userId)
    {
        return DB::transaction(function () use ($cajaOperativaId, $monto, $concepto, $userId) {
            
            $boveda = Caja::where('tipo', 'boveda')->firstOrFail();
            $sesionCaja = SesionCaja::where('caja_id', $cajaOperativaId)->where('estado', 'abierta')->first();

            if (!$sesionCaja) {
                throw new Exception("Tu caja no tiene un turno abierto.");
            }

            $this->registrarMovimiento(
                $sesionCaja, 
                TipoMovimientoCaja::EGRESO, 
                $monto, 
                "Envío de efectivo a Contaduría - Concepto: $concepto", 
                $userId
            );

            return SolicitudTraspaso::create([
                'caja_origen_id' => $cajaOperativaId, 
                'caja_destino_id' => $boveda->id,     
                'monto_solicitado' => $monto,
                'concepto' => $concepto,
                'user_solicita_id' => $userId,
                'estado' => 'pendiente'
            ]);
        });
    }

    public function registrarGastoConTriangulacion(SesionCaja $sesionCajero, array $datos): void
    {
        DB::transaction(function () use ($sesionCajero, $datos) {
            if ($datos['origen'] === 'fondo') {
                $this->ejecutarTraspasoInternoFondoACaja($sesionCajero, $datos['monto'], $datos['concepto']);
            }

            $this->registrarMovimiento(
                sesion: $sesionCajero,
                tipo: TipoMovimientoCaja::from($datos['tipo']),
                monto: $datos['monto'],
                concepto: $datos['concepto'],
                userId: Auth::id(),
                descripcion: $datos['descripcion'],
                nombre_paciente: $datos['nombre_paciente'],
                area: $datos['area'] ?? null,
                metodoPagoId: $datos['metodo_pago_id'] ?? null,
                factura: $datos['factura'],
            );
        });
    }

    private function ejecutarTraspasoInternoFondoACaja(SesionCaja $sesionCajero, float $monto, string $concepto): void
    {
        $sesionFondo = SesionCaja::whereHas('caja', fn($q) => $q->where('tipo', 'fondo'))
            ->where('estado', 'abierta')
            ->firstOrFail();

        // Salida de fondo
        $this->registrarMovimiento(
            sesion: $sesionFondo,
            tipo: TipoMovimientoCaja::EGRESO,
            monto: $monto,
            concepto: "FONDO: Envío para pago de " . $concepto,
            userId: Auth::id()
        );

        // Entrada a la caja del cajero
        $this->registrarMovimiento(
            sesion: $sesionCajero,
            tipo: TipoMovimientoCaja::INGRESO,
            monto: $monto,
            concepto: "FONDO: Recepción para pago de " . $concepto,
            userId: Auth::id()
        );
    }
        

    private function notificarDiscrepanciaAContador(SesionCaja $sesion, float $diferencia)
    {
        $contadores = User::whereHas('roles', fn($q) => $q->where('name', 'contador'))->get();

        $mensaje = [
            'title' => '⚠️ Discrepancia en Cierre',
            'message' => "La {$sesion->caja->nombre} cerró con una diferencia de $" . number_format($diferencia, 2),
            'type' => 'warning',
            'sesion_id' => $sesion->id
        ];

        Notification::send($contadores, new DiscrepanciaSesion($sesion, $diferencia));
    }

    private function notificarDiscrepanciaApertura($ultimaSesion, $usuarioEntrante, $diferencia)
    {
        $contadores = User::whereHas('roles', fn($q) => $q->where('name', 'contador'))->get();

        $tipo = $diferencia < 0 ? 'FALTANTE' : 'SOBRANTE';
        
        $mensaje = [
            'title' => "⚠️ DISCREPANCIA EN APERTURA",
            'message' => "El usuario {$usuarioEntrante->nombre_completo} inició caja con un $tipo de $" . abs($diferencia) . " respecto al cierre anterior.",
            'type' => 'error', 
            'action_url' => "tesoreria/boveda?tab=sesiones",
        ];

        Notification::send($contadores, new DiscrepanciaSesion($ultimaSesion, $diferencia));
    }

}