<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $pregunta
 * @property int $orden
 * @property string $categoria
 * @property bool $permite_desconozco
 * @property array<array-key, mixed>|null $opciones_respuesta
 * @property string $tipo_pregunta
 * @property array<array-key, mixed>|null $campos_adicionales
 * @property int $formulario_catalogo_id
 * @property-read \App\Models\FormularioCatalogo $formularioCatalogo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta whereCamposAdicionales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta whereFormularioCatalogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta whereOpcionesRespuesta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta wherePermiteDesconozco($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta wherePregunta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoPregunta whereTipoPregunta($value)
 * @mixin \Eloquent
 */
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
