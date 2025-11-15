<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaEgreso extends Model
{
     public const CATALOGO_ID = 11;
    protected $table = 'nota_egresos';
    protected $fillable = [
        'id',
        'fecha_ingereso',
        'fecha_egreso',
        'motivo_egreso',
        'diagnosticos_finales',
        'resumen_evolucion_estado_actual',
        'manejo_durante_estancia',
        'problemas_pendientes',
        'plan_manejo_tratamiento',
        'recomendaciones',
        'factores_riesgo',
        'pronostico',
        'defuncion',
    ];
      public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
