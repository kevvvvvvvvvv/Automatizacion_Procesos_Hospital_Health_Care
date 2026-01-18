<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property string $fecha_hora_registro
 * @property int|null $uresis
 * @property string|null $uresis_descripcion
 * @property int|null $evacuaciones
 * @property string|null $evacuaciones_descripcion
 * @property int|null $emesis
 * @property string|null $emesis_descripcion
 * @property int|null $drenes
 * @property string|null $drenes_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaEnfermeria $hojaEnfermeria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereDrenes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereDrenesDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereEmesis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereEmesisDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereEvacuaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereEvacuacionesDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereFechaHoraRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereUresis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaControlLiquido whereUresisDescripcion($value)
 * @mixin \Eloquent
 */
class HojaControlLiquido extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'fecha_hora_registro',
        'uresis',
        'uresis_descripcion',
        'evacuaciones',
        'evacuaciones_descripcion',
        'emesis',
        'emesis_descripcion',
        'drenes',
        'drenes_descripcion',
    ];

    public function hojaEnfermeria():BelongsTo
    {   
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }
}
