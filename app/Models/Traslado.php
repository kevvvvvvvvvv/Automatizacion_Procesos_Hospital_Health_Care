<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    public const CATALOGO_ID = 6;
    protected $table = 'traslado';
    protected $fillable = [
        'id',
        'unidad_medica_envia',
        'unidad_medica_recibe',
        'motivo_translado',
        'impresion_diagnostica',
        'terapeutica_empleada',
    ];
    public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
    
}
