<?php

namespace App\Models;

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
