<?php

namespace App\Models\Formulario\HistoriaClinica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Formulario\FormularioCatalogo;

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
        'opciones_respuesta',
        'formulario_catalogo_id',
    ];

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'opciones_respuesta' => 'array',
        'campos_adicionales' => 'array',
        'permite_desconozco' => 'boolean',
    ];

    public function formularioCatalogo(): BelongsTo
    {
        return $this->belongsTo(FormularioCatalogo::class);
    }
}
