<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaPostoperatoria extends Model
{
    public const ID_CATALOGO =

    protected $fillable = [
        'id',
        'hora_inicio_operacion',
        'hora_termino_operacion',
        'diagnostico_preoperatorio', 
        'operacion_planeada',
        'operacion_realizada',
        'diagnostico_postoperatorio',
        'descripcion_tecnica_quirurgica',
        'hallazgos_transoperatorios',
        'reporte_conteo',
        'incidentes_accidentes',
        'cuantificacion_sangrado',
        'estudios_transoperatorios',
        'ayudantes',
        'estado_postquirurgico',
        'manejo_tratamiento',
        'pronostico',
        'envio_piezas',
        'hallazgos_importancia',
    ];


    public function formularioInstancia():BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }


}
