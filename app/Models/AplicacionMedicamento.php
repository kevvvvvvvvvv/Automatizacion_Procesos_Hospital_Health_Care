<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $hoja_medicamento_id
 * @property string $fecha_aplicacion
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaMedicamento $hojaMedicamento
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento whereFechaAplicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento whereHojaMedicamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AplicacionMedicamento whereUserId($value)
 * @mixin \Eloquent
 */
class AplicacionMedicamento extends Model
{
    protected $fillable = [
        'hoja_medicamento_id',
        'fecha_aplicacion',
        'user_id',
    ];

    public function hojaMedicamento()
    {
        return $this->belongsTo(HojaMedicamento::class);
    }
}
