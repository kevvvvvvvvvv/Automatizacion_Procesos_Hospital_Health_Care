<?php

namespace App\Models\Caja;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesionCaja extends Model
{
    protected $fillable = [
        'id',
        'caja_id',
        'user_id',

        'fecha_apertura',
        'fecha_cierre',

        'monto_inicial',
        'estado',

        'total_ingresos_efectivo',
        'total_egresos_efectivo',
        'total_otros_metodos',

        'monto_declarado',
        'sobrante_faltante',
    ];

    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
