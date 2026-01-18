<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $producto_servicio_id
 * @property int $hoja_enfermeria_quirofano_id
 * @property int $cantidad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaEnfermeriaQuirofano $hojaEnfermeriaQuirofano
 * @property-read \App\Models\ProductoServicio $productoServicio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos whereHojaEnfermeriaQuirofanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos whereProductoServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaInsumosBasicos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaInsumosBasicos extends Model
{
    protected $fillable = [
        'id',
        'producto_servicio_id',
        'hoja_enfermeria_quirofano_id',
        'cantidad',
    ];

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class);
    }

    public function hojaEnfermeriaQuirofano(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeriaQuirofano::class);
    }

    
}
