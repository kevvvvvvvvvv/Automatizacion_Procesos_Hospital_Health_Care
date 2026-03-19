<?php

namespace App\Models\Formulario\HojaEnfermeria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Inventario\ProductoServicio;

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
