<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $categoria_dieta_id
 * @property string $alimento
 * @property string $costo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CategoriaDieta $categoriaDieta
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetalleVenta> $detallesVenta
 * @property-read int|null $detalles_venta_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta whereAlimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta whereCategoriaDietaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta whereCosto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dieta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dieta extends Model
{
    
    protected $fillable = [
        'categoria_dieta_id',
        'alimento',
        'costo'
    ];


    public function categoriaDieta(): BelongsTo
    {
        return $this->belongsTo(CategoriaDieta::class);
    }

    public function detallesVenta()
    {
        return $this->morphMany(DetalleVenta::class,'itemable');
    }
}
