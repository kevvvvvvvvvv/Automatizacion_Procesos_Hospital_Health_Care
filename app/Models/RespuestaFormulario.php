<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RespuestaFormulario extends Model
{
    protected $table = 'respuesta_formularios';


    protected $fillable = [
        'id',
        'detalles',
        'catalogo_pregunta_id',
        'historia_clinica_id',
    ];

    public $timestamps = false;

    protected $casts = [
        'detalles' => 'array',
    ];

    public function catalogoPreguntas():BelongsTo
    {
        return $this->belongsTo(CatalogoPregunta::class,'catalogo_pregunta_id');
    }

    public function historiaClinica(): BelongsTo
    {
        return $this->belongsTo(HistoriaClinica::class,'historia_clinica_id');
    }
}
