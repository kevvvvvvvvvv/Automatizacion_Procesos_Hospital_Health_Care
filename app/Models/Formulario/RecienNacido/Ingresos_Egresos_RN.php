<?php

namespace App\Models\Formulario\RecienNacido;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingresos_Egresos_RN extends Model
{
    protected $table = 'ingresos__egresos__r_n_s';
    protected $fillable = [
    'hoja_enfermeria_id',
    'seno_materno',
    'formula',
    'otros_ingresos',
    'cantidad_ingresos',
    'miccion',
    'evacuacion',
    'emesis',
    'otros_egresos',
    'cantidad_egresos',
    'balance_total',
];
    public function recienNacido(): BelongsTo
    {
        return $this->belongsTo(RecienNacido::class, 'hoja_enfermeria_id');
    }
}
