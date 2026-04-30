<?php

namespace App\Models\Formulario\RecienNacido;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property float|null $seno_materno
 * @property float|null $formula
 * @property string|null $otros_ingresos
 * @property float|null $cantidad_ingresos
 * @property float|null $miccion
 * @property float|null $evacuacion
 * @property float|null $emesis
 * @property string|null $otros_egresos
 * @property float|null $cantidad_egresos
 * @property float|null $balance_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Formulario\RecienNacido\RecienNacido $recienNacido
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereBalanceTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereCantidadEgresos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereCantidadIngresos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereEmesis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereEvacuacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereFormula($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereMiccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereOtrosEgresos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereOtrosIngresos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereSenoMaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingresos_Egresos_RN whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ingresos_Egresos_RN extends Model
{
    protected $table = 'ingresos__egresos__r_n_s';
    protected $fillable = [
    'hoja_enfermeria_id',
    'seno_materno',
    'formula',
    'otros_ingresos',
    'cantidad_ingresos',
    'miccion',
    'evacuacion',
    'emesis',
    'otros_egresos',
    'cantidad_egresos',
    'balance_total',
];
    public function recienNacido(): BelongsTo
    {
        return $this->belongsTo(RecienNacido::class, 'hoja_enfermeria_id');
    }
}
