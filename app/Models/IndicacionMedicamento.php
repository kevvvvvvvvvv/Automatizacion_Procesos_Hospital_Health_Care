<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $itemable_type
 * @property int $itemable_id
 * @property int|null $producto_servicio_id
 * @property string $nombre_medicamento
 * @property int $dosis
 * @property string $gramaje
 * @property string $unidad
 * @property string|null $via_administracion
 * @property string $duracion_tratamiento
 * @property string $razon_necesaria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereDosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereDuracionTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereGramaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereItemableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereItemableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereNombreMedicamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereProductoServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereRazonNecesaria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereUnidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndicacionMedicamento whereViaAdministracion($value)
 * @mixin \Eloquent
 */
class IndicacionMedicamento extends Model
{
    //
}
