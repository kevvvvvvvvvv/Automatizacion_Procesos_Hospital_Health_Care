<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudEstudio extends Model
{
    protected $fillable = [
        'id',
        'user_solicita_id',
        'user_llena_id',
        'problemas_clinicos',
        'incidentes_accidentes',
        'resultado',
    ];

    public function userSolicita():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_solicita_id', 'id');
    }

    public function userLlena(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_llena_id', 'id');
    }

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

}
