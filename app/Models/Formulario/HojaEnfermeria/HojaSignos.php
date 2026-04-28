<?php

namespace App\Models\Formulario\HojaEnfermeria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 


/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property string $fecha_hora_registro
 * @property int|null $tension_arterial_sistolica
 * @property int|null $tension_arterial_diastolica
 * @property int|null $frecuencia_cardiaca
 * @property int|null $frecuencia_respiratoria
 * @property string|null $temperatura
 * @property int|null $saturacion_oxigeno
 * @property int|null $glucemia_capilar
 * @property string|null $talla
 * @property string|null $peso
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Formulario\HojaEnfermeria\HojaEnfermeria $hojaEnfermeria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereFechaHoraRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereFrecuenciaCardiaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereFrecuenciaRespiratoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereGlucemiaCapilar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereSaturacionOxigeno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereTemperatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereTensionArterialDiastolica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereTensionArterialSistolica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereUpdatedAt($value)
 * @mixin \Eloq uent
 * @property string $registrable_type
 * @property int $registrable_id
 * @property-read Model|\Eloquent $registrable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereRegistrableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaSignos whereRegistrableType($value)
 * @mixin \Eloquent
 */
class HojaSignos extends Model
{
    protected $table = 'hoja_registros';
    
    protected $fillable = [
        'registrable_id',  
        'registrable_type',
        'fecha_hora_registro',
        'tension_arterial_sistolica',
        'tension_arterial_diastolica',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'temperatura',
        'saturacion_oxigeno',
        'glucemia_capilar',
        'talla',
        'peso',
    ];

    public function registrable() {
        return $this->morphTo();
    }

    public function hojaEnfermeria():BelongsTo
    {   
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }

}
