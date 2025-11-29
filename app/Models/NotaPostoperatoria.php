<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotaPostoperatoria extends Model
{
    public const ID_CATALOGO = 8;

    public $incrementing = false;

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
        'tratamiento',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'pronostico',

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
        'estado_postquirurgico',

        'manejo_dieta',
        'manejo_soluciones',
        'manejo_medicamentos',
        'manejo_medidas_generales',
        'manejo_laboratorios',
        
        'pronostico',
        //'envio_piezas',
        'hallazgos_importancia',
        'solicitud_patologia_id',
    ];


    public function formularioInstancia():BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    public function personalEmpleados(): HasMany
    {
        return $this->hasMany(PersonalEmpleado::class, 'nota_postoperatoria_id', 'id');
    }

    public function transfusiones(): HasMany
    {
        return $this->hasMany(TransfusionRealizada::class, 'nota_postoperatoria_id', 'id');
    }

}
