<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $producto_servicio_id
 * @property string|null $fecha_instalacion
 * @property string|null $fecha_caducidad
 * @property int $user_id
 * @property string|null $observaciones
 * @property int $hoja_enfermeria_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaEnfermeria $hojaEnfermeria
 * @property-read \App\Models\ProductoServicio $productoServicio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereFechaCaducidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereFechaInstalacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereProductoServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSondaCateter whereUserId($value)
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class HojaSondaCateter extends Model
{
    protected $table = 'hoja_sonda_cateters';

    protected $fillable = [
        'id',

        'producto_servicio_id',

        'fecha_instalacion',
        'fecha_caducidad',
        'user_id',
        'observaciones',
        'hoja_enfermeria_id',
    ];

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class);
    }

}
