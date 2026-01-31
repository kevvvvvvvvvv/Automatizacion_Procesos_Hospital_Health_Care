<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $tipo
 * @property string $subtipo
 * @property string $codigo_prestacion
 * @property string $nombre_prestacion
 * @property string $importe
 * @property int|null $cantidad
 * @property string $iva
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetalleVenta> $detallesVenta
 * @property-read int|null $detalles_venta_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCodigoPrestacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereImporte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereNombrePrestacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereSubtipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereTipo($value)
 * @mixin \Eloquent
 */
class ProductoServicio extends Model
{
    public const IVA = 1.16;

    protected $table = 'producto_servicios';
    public $incrementing = true;

    protected $fillable = [
        'tipo',
        'subtipo',
        'codigo_prestacion',
        'nombre_prestacion',
        'importe',
        'cantidad',
        'iva'
    ];

    public function detallesVenta()
    {
        return $this->morphMany(DetalleVenta::class, 'itemable');
    }

    public function medicamento() {
        return $this->hasOne(Medicamento::class, 'id');
    }

    public function insumo() {
        return $this->hasOne(Insumo::class, 'id');
    }

}
