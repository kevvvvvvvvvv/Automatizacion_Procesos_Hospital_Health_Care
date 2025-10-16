<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriaClinica extends Model
{
    protected $table ='historia_clinicas';

    protected $fillable = [
        'id',
        'padecimiento_actual',
        'tension_arterial',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'temperatura',
        'peso',
        'talla',
        'resultados_previos',
        'diagnostico',
        'pronostico',
        'indicacion_terapeutica',
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id','id');
    }
}
