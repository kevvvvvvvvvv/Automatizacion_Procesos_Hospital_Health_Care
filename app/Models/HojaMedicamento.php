<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductoServicio;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaMedicamento extends Model
{
    
    protected $table = 'hoja_medicamentos';

    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'producto_servicio_id',
        'dosis',
        'gramaje',
        'via_administracion',
        'duracion_tratamiento',
        'fecha_hora_inicio',
        'estado',
        'fecha_hora_solicitud',
        'fecha_hora_surtido_farmacia',
        'farmaceutico_id',
        'fecha_hora_recibido_enfermeria',
    ];

    public function productoServicio():BelongsTo
    {   
        return $this->belongsTo(ProductoServicio::class,'producto_servicio_id');
    }

    public function hojaEnfermeria():BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }
}
