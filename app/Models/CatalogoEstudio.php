<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $codigo
 * @property string $nombre
 * @property string $tipo_estudio
 * @property string $departamento
 * @property int|null $tiempo_entrega
 * @property string $costo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetalleVenta> $detallesVenta
 * @property-read int|null $detalles_venta_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SolicitudItem> $solicitudItem
 * @property-read int|null $solicitud_item_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereCosto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereTiempoEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereTipoEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoEstudio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatalogoEstudio extends Model
{
    
    protected $fillable = [
        'id',
        'nombre',
        'tipo_estudio',
        'departamento',
        'tiempo_entrega',
        'costo',
        'clave_producto_servicio',
    ];

    public function solicitudItem(): HasMany
    {
        return $this->hasMany(SolicitudItem::class);
    }

    public function detallesVenta()
    {
        return $this->morphMany(DetalleVenta::class, 'itemable');
    }
}
