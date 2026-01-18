<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $user_solicita_id
 * @property int $user_llena_id
 * @property string|null $problemas_clinicos
 * @property string|null $incidentes_accidentes
 * @property string|null $resultado
 * @property string|null $itemable_type
 * @property int|null $itemable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @property-read Model|\Eloquent|null $itemable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SolicitudItem> $solicitudItems
 * @property-read int|null $solicitud_items_count
 * @property-read \App\Models\User $userLlena
 * @property-read \App\Models\User $userSolicita
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereIncidentesAccidentes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereItemableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereItemableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereUserLlenaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudEstudio whereUserSolicitaId($value)
 * @mixin \Eloquent
 */
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
