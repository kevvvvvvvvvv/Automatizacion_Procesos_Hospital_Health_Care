<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $nota_postoperatoria_id
 * @property string $tipo_transfusion
 * @property string $cantidad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\NotaPostoperatoria $notaPostoperatoria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada whereNotaPostoperatoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada whereTipoTransfusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransfusionRealizada whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TransfusionRealizada extends Model
{
    protected $table = 'transfusion_realizadas';

    protected $fillable = [
        'id',
        'nota_postoperatoria_id',
        'tipo_transfusion',
        'cantidad',
    ];

    public function notaPostoperatoria(): BelongsTo
    {
        return $this->belongsTo(NotaPostoperatoria::class, 'nota_postoperatoria_id', 'id');
    }    

}
