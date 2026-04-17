<?php

namespace App\Models\Formulario\HojaEnfermeria;

use App\Enums\TipoEgresoLiquido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EgresoLiquido extends Model
{
    protected $fillable = [
        'liquidable_id',
        'liquidable_type',
        'tipo',
        'cantidad',
        'descripcion',
    ];

    protected $casts = [
        'tipo' => TipoEgresoLiquido::class,
    ];

    public function liquidable(): MorphTo
    {
        return $this->morphTo();
    }
}
