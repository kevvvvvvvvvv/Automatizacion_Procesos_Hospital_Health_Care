<?php

namespace App\Models\Venta;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'tipo_ajuste',
        'valor_ajuste',
        'activo',
        'created_at',
        'updated_at',
    ];

}
