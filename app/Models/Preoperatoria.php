<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preoperatoria extends Model
{
    public const CATALOGO_ID = 7;
    protected $table = 'preoperatorios';
    protected $fillable = [
        'id',
        'fecha_cirugia',
        'diagnostico_preoperatorio',
        'plan_quirurgico',
        'tipo_intervencion_quirurgica',
        'riesgo_quirurgico',
        'cuidados_plan_preoperatorios',
        'pronostico',
        ];
    public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
