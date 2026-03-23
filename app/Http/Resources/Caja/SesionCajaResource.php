<?php

namespace App\Http\Resources\Caja;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SesionCajaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // 1. Proteger el estado (Si llega como Enum le saca el valor, si llega como texto lo deja igual)
        $estadoSeguro = $this->estado instanceof \UnitEnum 
            ? $this->estado->value 
            : $this->estado;

        // 2. Calcular el monto esperado matemáticamente por si no existe en la BD
        $montoEsperado = $this->monto_esperado ?? (
            $this->monto_inicial + $this->total_ingresos_efectivo - $this->total_egresos_efectivo
        );

        return [
            'id' => $this->id,
            'caja_id' => $this->caja_id,
            'user_id' => $this->user_id,
            
            // 3. Pasamos las fechas directas porque el dd() muestra que ya son strings válidos
            'fecha_apertura' => $this->fecha_apertura,
            'fecha_cierre' => $this->fecha_cierre,
            
            'estado' => $estadoSeguro,
            
            'monto_inicial' => (float) $this->monto_inicial,
            'total_ingresos_efectivo' => (float) $this->total_ingresos_efectivo,
            'total_egresos_efectivo' => (float) $this->total_egresos_efectivo,
            'total_otros_metodos' => (float) $this->total_otros_metodos,
            'monto_esperado' => (float) $montoEsperado,
            
            // La magia final para que aparezca la tabla
            'movimientos' => $this->whenLoaded('movimientos'),
        ];
    }
}
