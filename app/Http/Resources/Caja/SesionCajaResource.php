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
        $estadoSeguro = $this->estado instanceof \UnitEnum 
            ? $this->estado->value 
            : $this->estado;

        $montoEsperado = $this->monto_esperado ?? (
            $this->monto_inicial + $this->total_ingresos_efectivo - $this->total_egresos_efectivo
        );

        return [
            'id' => $this->id,
            'caja_id' => $this->caja_id,
            'user_id' => $this->user_id,
            
            'fecha_apertura' => $this->fecha_apertura,
            'fecha_cierre' => $this->fecha_cierre,
            
            'estado' => $estadoSeguro,
            
            'monto_inicial' => (float) $this->monto_inicial,
            'total_ingresos_efectivo' => (float) $this->total_ingresos_efectivo,
            'total_egresos_efectivo' => (float) $this->total_egresos_efectivo,
            'total_otros_metodos' => (float) $this->total_otros_metodos,
            'monto_esperado' => (float) $montoEsperado,
            
            'movimientos' => $this->whenLoaded('movimientos'),
        ];
    }
}
