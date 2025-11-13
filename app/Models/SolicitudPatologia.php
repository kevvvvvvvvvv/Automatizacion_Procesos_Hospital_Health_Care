<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudPatologia extends Model
{
    public const ID_CATALOGO = 10;

    protected $table = 'solicitud_patologias';

    protected $fillable = [
        'id',
        'user_solicita_id',
        'fecha_estudio',
        'estudio_solicitado',
        'biopsia_pieza_quirurgica',
        'revision_laminillas',
        'estudios_especiales',
        'pcr',
        'pieza_remitida',
        'datos_clinicos',
        'resultados',
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
