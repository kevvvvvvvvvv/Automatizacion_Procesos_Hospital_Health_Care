<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SolicitudItem extends Model
{
    protected $fillable = [
        'id',
        'solicitud_estudio_id',
        'catalogo_estudio_id',
        'estado',
        'otro_estudio',
        'detalles',
        'user_realiza_id',
        'resultados,'
    ];

    protected $casts = [
        'detalles' => 'array',
    ];

    public function solicitudEstudio(): BelongsTo
    {
        return $this->belongsTo(SolicitudEstudio::class);
    }

    public function catalogoEstudio(): BelongsTo
    {
        return $this->belongsTo(CatalogoEstudio::class);
    }
}
