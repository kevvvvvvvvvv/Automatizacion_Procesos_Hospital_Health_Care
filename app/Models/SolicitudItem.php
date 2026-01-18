<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $solicitud_estudio_id
 * @property int|null $catalogo_estudio_id
 * @property array<array-key, mixed>|null $detalles
 * @property string|null $otro_estudio
 * @property string $estado
 * @property int|null $user_realiza_id
 * @property string|null $fecha_realizacion
 * @property string|null $problema_clinico
 * @property string|null $incidentes_accidentes
 * @property string|null $ruta_archivo_resultado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CatalogoEstudio|null $catalogoEstudio
 * @property-read \App\Models\SolicitudEstudio $solicitudEstudio
 * @property-read \App\Models\User|null $userRealiza
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereCatalogoEstudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereDetalles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereFechaRealizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereIncidentesAccidentes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereOtroEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereProblemaClinico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereRutaArchivoResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereSolicitudEstudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItem whereUserRealizaId($value)
 * @mixin \Eloquent
 */
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
        'ruta_archivo_resultado'
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
}
