<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property int $solucion
 * @property int $cantidad
 * @property string $duracion
 * @property string $flujo_ml_hora
 * @property string|null $fecha_hora_inicio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductoServicio $detalleSoluciones
 * @property-read \App\Models\HojaEnfermeria $hojaEnfermeria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereDuracion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereFechaHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereFlujoMlHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereSolucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaTerapiaIV extends Model
{
    protected $table = 'hoja_terapias';
    
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'solucion',
        'cantidad',
        'duracion',
        'flujo_ml_hora',
        'fecha_hora_inicio',
    ];

    public function detalleSoluciones():BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'solucion','id');
    }

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

}
