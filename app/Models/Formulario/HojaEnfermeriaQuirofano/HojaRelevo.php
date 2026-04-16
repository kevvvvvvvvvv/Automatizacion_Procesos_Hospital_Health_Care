<?php

namespace App\Models\Formulario\HojaEnfermeriaQuirofano;

use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class HojaRelevo extends Model
{
    protected $fillable = [ 
        'hoja_enfermeria_quirofano_id',
        'user_id',
        'hora_entrada',
        'hora_salida',
        'observaciones_entrega',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hojaEnfermeriaQuirofano(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

    
}
