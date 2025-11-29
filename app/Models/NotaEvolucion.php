<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaEvolucion extends Model
{
    public const CATALOGO_ID = 12;
    protected $table = 'notas_evoluciones';
    protected $fillable = [
        'id',
        'evolucion_actualizacion',
        'ta',
        'fc',
        'fr',
        'temp',
        'peso',
        'talla',
        'resultado_estudios',
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'tratamiento',

        // Pronóstico
        'pronostico',

        'manejo_dieta',
        'manejo_soluciones',
        'manejo_medicamentos',
        'manejo_laboratorios',
        'manejo_medidas_generales',
        
    ];
    public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}



