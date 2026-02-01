<?php

namespace App\Models;

use App\Models\Inventario\Medicamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property int $id
 * @property int $medicamento_id
 * @property int $catalogo_via_administracion_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia whereCatalogoViaAdministracionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia whereMedicamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicamentoVia whereUpdatedAt($value)
 * @property-read \App\Models\CatalogoViaAdministracion $catalogoViaAdministracion
 * @property-read Medicamento $medicamento
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CatalogoViaAdministracion> $viasAdministracion
 * @property-read int|null $vias_administracion_count
 * @mixin \Eloquent
 */
class MedicamentoVia extends Model
{
    protected $fillable = [
        'medicamento_id',
        'catalogo_via_administracion_id',
    ];

    public function medicamento(): BelongsTo
    {
        return $this->belongsTo(Medicamento::class);
    } 

    public function viasAdministracion(): BelongsTo
    {
        return $this->belongsTo(CatalogoViaAdministracion::class);
    }

}
