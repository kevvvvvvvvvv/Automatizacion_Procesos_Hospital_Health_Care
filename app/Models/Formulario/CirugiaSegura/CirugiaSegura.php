<?php

namespace App\Models\Formulario\CirugiaSegura;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Formulario\FormularioInstancia;

class CirugiaSegura extends Model
{
    protected $fillable = [
        'id', 
        'servicio_procedencia',
        'cirugia_programada',
        'cirugia_realizada',
        'grupo_rh',
        'confirmar_indentidad',
        'sitio_quirurgico',
        'funcionamiento_aparatos',
        'oximetro',
        'alergias',
        'via_aerea',
        'riesgo_hemorragia',
        'hemoderivados',
        'profilaxis',
        'miembros_equipo',
        'indentidad_paciente',
        'pasos_criticos',
        'tiempo_aproximado',
        'perdida_sanguinea',
        'revision_anestesiologo',
        'esterilizacion',
        'dudas_problemas',
        'imagenes_diagnosticas',
        'nombre_procedimiento',
        'recuento_instrumentos',
        'faltantes',
        'observaciones',
        'etiquetado_muestras',
        'aspectos_criticos'
    ];
    public function formularioInstancia(): BelongsTo 
    {
        return $this->belongsTo(FormularioInstancia);
    }
    
}
