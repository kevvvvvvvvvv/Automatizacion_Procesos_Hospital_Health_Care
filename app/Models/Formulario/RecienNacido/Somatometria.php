<?php

namespace App\Models\Formulario\RecienNacido;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Formulario\RecienNacido;

class Somatometria extends Model
{
    protected $table = 'somatometrias';

    protected $fillable = [
        'hoja_enfermeria_id',
        'perimetro_toracico',
        'perimetro_cefalico',
        'perimetro_abdominal',
        'pie',
        'segmento_inferior',
        'capurro',
        'apgar',
        'silverman'
    ];

    public function recienNacido(): BelongsTo
    {
        return $this->belongsTo(RecienNacido::class, 'hoja_enfermeria_id');
    }
}