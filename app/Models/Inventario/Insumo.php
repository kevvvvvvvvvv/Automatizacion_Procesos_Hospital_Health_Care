<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ProductoServicio;

/**
 * @property int $id
 * @property string $categoria
 * @property string $especificacion
 * @property string $categoria_unitaria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereCategoriaUnitaria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereEspecificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereUpdatedAt($value)
 * @property-read ProductoServicio $productoServicio
 * @mixin \Eloquent
 */
class Insumo extends Model
{
    protected $fillable = [
        'id',
        'categoria',
        'especificacion',
        'categoria_unitaria',
    ];

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'id', 'id');
    }
}
