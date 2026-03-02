<?php

namespace App\Models\Formulario\NotaUrgencia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Formulario\FormularioInstancia;

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
    
    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
