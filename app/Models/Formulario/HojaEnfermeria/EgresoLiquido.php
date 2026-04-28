<?php

namespace App\Models\Formulario\HojaEnfermeria;

use App\Enums\TipoEgresoLiquido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $liquidable_type
 * @property int $liquidable_id
 * @property TipoEgresoLiquido $tipo uresis, diuresis, etc
 * @property float $cantidad ml
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $liquidable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereLiquidableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereLiquidableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EgresoLiquido whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EgresoLiquido extends Model
{
    protected $fillable = [
        'liquidable_id',
        'liquidable_type',
        'tipo',
        'cantidad',
        'descripcion',
    ];

    protected $casts = [
        'tipo' => TipoEgresoLiquido::class,
    ];

    public function liquidable(): MorphTo
    {
        return $this->morphTo();
    }
}
