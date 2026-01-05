<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SolicitudEstudio extends Model
{
    protected $fillable = [
        'id',
        'user_solicita_id',
        'user_llena_id',
        'problemas_clinicos',
        'incidentes_accidentes',
        'resultado',
        'itemable_type',
        'itemable_id'
    ];

    public $incrementing = false;

    public function userSolicita():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_solicita_id', 'id');
    }

    public function userLlena(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_llena_id', 'id');
    }

    public function solicitudItems(): HasMany
    {
        return $this->hasMany(SolicitudItem::class);
    }

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }


    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }
}
