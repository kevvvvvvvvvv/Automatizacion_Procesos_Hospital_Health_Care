<?php

namespace App\Models\Estudio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Models\Estudio\SolicitudEstudio;

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

        'fecha_realizacion',
        'problema_clinico',
        'incidentes_accidentes',
    ];

    protected $casts = [
        'detalles' => 'array',
    ];

    public function solicitudEstudio(): BelongsTo
    {
        return $this->belongsTo(SolicitudEstudio::class);
    }

    public function userRealiza(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function catalogoEstudio(): BelongsTo
    {
        return $this->belongsTo(CatalogoEstudio::class);
    }

    public function archivos(): HasMany
    {
        return $this->hasMany(SolicitudItemArchivo::class);
    }
}
