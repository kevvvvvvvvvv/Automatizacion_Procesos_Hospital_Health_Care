<?php

namespace App\Models\Formulario\HojaEnfermeria;

use Illuminate\Database\Eloquent\Model;

class AplicacionMedicamento extends Model
{
    protected $fillable = [
        'hoja_medicamento_id',
        'fecha_aplicacion',
        'user_id',
    ];

    public function hojaMedicamento()
    {
        return $this->belongsTo(HojaMedicamento::class);
    }
}
