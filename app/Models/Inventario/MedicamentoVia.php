<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
