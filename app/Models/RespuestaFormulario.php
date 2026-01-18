<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property array<array-key, mixed> $detalles
 * @property int $catalogo_pregunta_id
 * @property int $historia_clinica_id
 * @property-read \App\Models\CatalogoPregunta $catalogoPreguntas
 * @property-read \App\Models\HistoriaClinica $historiaClinica
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RespuestaFormulario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RespuestaFormulario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RespuestaFormulario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RespuestaFormulario whereCatalogoPreguntaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RespuestaFormulario whereDetalles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RespuestaFormulario whereHistoriaClinicaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RespuestaFormulario whereId($value)
 * @mixin \Eloquent
 */
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
