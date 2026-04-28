<?php

namespace App\Models\Formulario\HojaEnfermeria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Inventario\ProductoServicio;

/**
 * @property int $id
 * @property int $hoja_terapia_id
 * @property int|null $producto_servicio_id
 * @property string $nombre_medicamento
 * @property numeric $dosis
 * @property string $unidad_medida
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ProductoServicio|null $productoServicio
 * @property-read \App\Models\Formulario\HojaEnfermeria\HojaTerapiaIV $terapiaIV
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereDosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereHojaTerapiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereNombreMedicamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereProductoServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereUnidadMedida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIVMedicamento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaTerapiaIVMedicamento extends Model
{
    protected $fillable = [
        'id',
        'hoja_terapia_id',
        'producto_servicio_id',
        'nombre_medicamento',
        'dosis',
        'unidad_medida',
    ];

    public function terapiaIV(): BelongsTo
    {
        return $this->belongsTo(HojaTerapiaIV::class, 'hoja_terapia_id','id');
    }

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class);
    }


    
}
