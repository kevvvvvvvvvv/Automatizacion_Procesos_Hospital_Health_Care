<?php

namespace App\Models\Formulario\HojaEnfermeria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Inventario\ProductoServicio;

class HojaMedicamento extends Model
{
    protected $table = 'hoja_medicamentos';

    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'producto_servicio_id',
        'dosis',
        'gramaje',
        'unidad',
        'via_administracion',
        'duracion_tratamiento',
        'fecha_hora_inicio',
        'estado',
        'fecha_hora_solicitud',
        'fecha_hora_surtido_farmacia',
        'farmaceutico_id',
        'fecha_hora_recibido_enfermeria',

        'nombre_medicamento'
    ];

    public function productoServicio():BelongsTo
    {   
        return $this->belongsTo(ProductoServicio::class,'producto_servicio_id');
    }

    public function hojaEnfermeria():BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }

    public function aplicaciones()
    {
        return $this->hasMany(AplicacionMedicamento::class)
                    ->orderBy('fecha_aplicacion', 'asc');
    }
}
