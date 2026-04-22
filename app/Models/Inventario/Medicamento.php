<?php

namespace App\Models\Inventario;

use App\Models\MedicamentoVia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Inventario\ProductoServicio;

/**
 * @property int $id
 * @property string $excipiente_activo_gramaje
 * @property string $volumen_total
 * @property string $nombre_comercial
 * @property string $gramaje
 * @property int $fraccion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereExcipienteActivoGramaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereFraccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereGramaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereNombreComercial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medicamento whereVolumenTotal($value)
 * @property-read ProductoServicio $productoServicio
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MedicamentoVia> $viasAdministracion
 * @property-read int|null $vias_administracion_count
 * @mixin \Eloquent
 */
class Medicamento extends Model
{
    protected $fillable = [
        'id',
        'excipiente_activo_gramaje',
        'volumen_total',
        'nombre_comercial',
        'gramaje',
        'fraccion',
    ];

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'id');
    }

    public function viasAdministracion(): BelongsToMany
    {
       return $this->belongsToMany(
            CatalogoViaAdministracion::class, 
            'medicamento_vias',               
            'medicamento_id',                 
            'catalogo_via_administracion_id'  
        );
    }
}
