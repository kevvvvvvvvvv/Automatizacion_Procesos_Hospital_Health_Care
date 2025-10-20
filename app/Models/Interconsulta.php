<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interconsulta extends Model
{
    protected $table = 'interconsultas';
     protected $fillable = [
        'id',
        'ta', 'fc', 'fr', 'temp', 'peso', 'talla',
       'criterio_diagnostico', 'plan_de_estudio', 'sugerencia_diagnostica',
       'motivo_de_la_atencion_o_interconsulta', 'resumen_del_interrogatorio',
       'exploracion_fisica', 'estado_mental', 'resultados_relevantes_del_estudio_diagnostico',
       'diagnostico_o_problemas_clinicos', 'tratamiento_y_pronostico',
   ];


    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id','id');
    }

   
}
