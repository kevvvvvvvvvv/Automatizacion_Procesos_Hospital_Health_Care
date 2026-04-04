<?php

namespace App\Models\Formulario\HojaEnfermeriaQuirofano;

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
}
