<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaPostanestesica extends Model
{
    protected $fillable = [
        'id',
        'ta',
        'fc',
        'fr',
        'temp',
        'peso',
        'talla',
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'resultado_estudios',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'pronostico',

        'tecnica_anestesica',
        'farmacos_administrados',
        'duracion_anestesia',
        'incidentes_anestesia',
        'balance_hidrico',
        'estado_clinico',
        'plan_manejo',
    ];

    public function formularioInstancia():BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
