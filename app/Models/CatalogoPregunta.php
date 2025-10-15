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
        'tipo_pregunta',
        'campos_adicionales',
        'permite_desconozco',
        'formulario_catalogo_id',
    ];

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'campos_adicionales' => 'array',
    ];

    public function formularioCatalogo(): BelongsTo
    {
        return $this->belongsTo(FormularioCatalogo::class);
    }
}
