<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaUrgencia extends Model
{
    public const CATALOGO_ID = 9;
    protected $table = 'nota_urgencias';
    protected $fillable = [
        'id',
        'ta',
        'fc',
        'fr',
        'temp',
        'peso',
        'talla',
        'motivo_atencion',
        'resumen_interrogatorio',
        'exploracion_fisica',
        'estado_mental',
        'resultados_relevantes',
        'diagnostico_problemas_clinicos',
        'tratamiento',
        'pronostico',
        
    ];
    
    public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
