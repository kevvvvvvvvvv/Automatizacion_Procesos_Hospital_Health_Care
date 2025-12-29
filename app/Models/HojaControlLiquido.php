<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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
