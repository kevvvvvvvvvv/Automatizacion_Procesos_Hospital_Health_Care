<?php

namespace App\Models\Formulario\Traslado;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Formulario\FormularioInstancia;


class Traslado extends Model
{
    public const CATALOGO_ID = 6;
    protected $table = 'traslado';
    protected $fillable = [
        'id',
        'id',
        'ta',
        'fc',
        'fr',
        'spo2',
        'peso',
        'talla',
        'temp',
        'resultado_estudios',
        'tratamiento',
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'pronostico',
        'unidad_medica_envia',
        'unidad_medica_recibe',
        'motivo_translado',
        'impresion_diagnostica',
        'terapeutica_empleada',
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
