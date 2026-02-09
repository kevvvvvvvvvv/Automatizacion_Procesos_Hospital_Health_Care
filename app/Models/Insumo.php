<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $categoria
 * @property string $especificacion
 * @property string $categoria_unitaria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductoServicio $productoServicio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereCategoriaUnitaria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereEspecificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insumo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Insumo extends Model
{
    protected $table = 'insumos';

    // Desactivamos el autoincremento porque heredamos el ID
    public $incrementing = false;

    protected $fillable = [
        'id',
        'categoria',
        'especificacion',
        'categoria_unitaria',
    ];

    /**
     * Relación inversa con el Producto/Servicio principal.
     */
    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'id');
    }
}