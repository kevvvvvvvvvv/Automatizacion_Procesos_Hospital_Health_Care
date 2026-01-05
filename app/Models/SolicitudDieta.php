<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudDieta extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',

        'dieta_id',

        'horario_solicitud',
        'user_supervisa_id',
        
        'horario_entrega',
        'user_entrega_id',
        
        'observaciones'
        
    ];

    public $timestamps = false;

    public function usuarioSupervisa():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_supervisa_id', 'id');
    }

    public function userEntrega():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_entrega_id', 'id');
    }

    public function dieta():BelongsTo
    {
        return $this->belongsTo(Dieta::class);
    }
}
