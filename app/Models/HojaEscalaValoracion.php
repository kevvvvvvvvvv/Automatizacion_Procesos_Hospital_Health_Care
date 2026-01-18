<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property string $fecha_hora_registro
 * @property string|null $escala_braden
 * @property string|null $escala_glasgow
 * @property string|null $escala_ramsey
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaEnfermeria $hojaEnfermeria
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ValoracionDolor> $valoracionDolor
 * @property-read int|null $valoracion_dolor_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereEscalaBraden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereEscalaGlasgow($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereEscalaRamsey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereFechaHoraRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEscalaValoracion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaEscalaValoracion extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'fecha_hora_registro',
        'escala_braden',
        'escala_glasgow',
        'escala_ramsey',
    ];

    public function hojaEnfermeria():BelongsTo
    {   
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }


    public function valoracionDolor(): HasMany
    {
        return $this->hasMany(ValoracionDolor::class);
    }

    
}
