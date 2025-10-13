<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalogoPregunta extends Model
{
    protected $table = 'catalogo_preguntas';
    protected $fillable = [
        'pregunta',
        'orden',
        'categoria',
        'formulario_catalogo_id'
    ];

    public $timestamps = false;

    public function formularioCatalogo(): BelongsTo
    {
        return $this->belongsTo(FormularioCatalogo::class);
    }
}
