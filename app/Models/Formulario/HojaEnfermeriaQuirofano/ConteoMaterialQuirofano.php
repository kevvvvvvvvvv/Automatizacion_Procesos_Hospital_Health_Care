<?php

namespace App\Models\Formulario\HojaEnfermeriaQuirofano;

use Attribute;
use Illuminate\Database\Eloquent\Model;

class ConteoMaterialQuirofano extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_quirofano_id',
        'tipo_material',
        'cantidad_inicial',
        'cantidad_agregada',
        'cantidad_final'
    ];

    public function getTipoMaterialLeibleAttribute()
    {
        $opciones = [
            'gasas_con_trama' => 'Gasas con trama',
            'compresas' => 'Compresas',
            'puchitos' => 'Puchitos',
            'cotonoides' => 'Cotonoides',
            'agujas' => 'Agujas',
        ];

        return $opciones[$this->tipo_material] ?? $this->tipo_material;
    }
}
