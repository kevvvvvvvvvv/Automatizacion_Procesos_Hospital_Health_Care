<?php

namespace App\Models\Formulario\RecienNacido;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Formulario\RecienNacido;
use App\Models\Formulario\RecienNacido\RecienNacido as FormularioRecienNacido;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property float|null $perimetro_toracico
 * @property float|null $perimetro_cefalico
 * @property float|null $perimetro_abdominal
 * @property float|null $pie
 * @property float|null $segmento_inferior
 * @property string|null $capurro
 * @property string|null $apgar
 * @property int|null $silverman
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereApgar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereCapurro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria wherePerimetroAbdominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria wherePerimetroCefalico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria wherePerimetroToracico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria wherePie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereSegmentoInferior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereSilverman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Somatometria whereUpdatedAt($value)
 * @property-read FormularioRecienNacido $recienNacido
 * @mixin \Eloquent
 */
class Somatometria extends Model
{
    protected $table = 'somatometrias';

    protected $fillable = [
        'hoja_enfermeria_id',
        'perimetro_toracico',
        'perimetro_cefalico',
        'perimetro_abdominal',
        'pie',
        'segmento_inferior',
        'capurro',
        'apgar',
        'silverman'
    ];

    public function recienNacido(): BelongsTo
    {
        return $this->belongsTo(FormularioRecienNacido::class, 'hoja_enfermeria_id');
    }
}