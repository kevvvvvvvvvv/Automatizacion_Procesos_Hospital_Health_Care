<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property int $id
 * @property string $nombre Nombre o ubicación de la caja (ej. Caja Principal, Farmacia)
 * @property int $activa Indica si la caja está habilitada para ser usada
 * @property string $tipo operativa, fondo, boveda
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Caja\SesionCaja> $sesionesCaja
 * @property-read int|null $sesiones_caja_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Caja\SolicitudTraspaso> $solicitudesRealizadas
 * @property-read int|null $solicitudes_realizadas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Caja\SolicitudTraspaso> $solicitudesRecibidas
 * @property-read int|null $solicitudes_recibidas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja whereActiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caja whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Caja extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'activa',
        'tipo',
    ];

    public function sesionesCaja(): HasMany
    {
        return $this->hasMany(SesionCaja::class);
    }

    public function solicitudesRealizadas(): HasMany
    {
        return $this->hasMany(SolicitudTraspaso::class, 'caja_destino_id');
    }

    public function solicitudesRecibidas():HasMany
    {
        return $this->hasMany(SolicitudTraspaso::class, 'caja_origen_id');
    }
}
