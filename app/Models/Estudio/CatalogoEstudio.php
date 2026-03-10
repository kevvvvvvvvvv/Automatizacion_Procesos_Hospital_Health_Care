<?php

namespace App\Models\Estudio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\Venta\DetalleVenta;

class CatalogoEstudio extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'tipo_estudio',
        'departamento',
        'tiempo_entrega',
        'link'
    ];

    public function solicitudItem(): HasMany
    {
        return $this->hasMany(SolicitudItem::class);
    }

    public function detallesVenta(): MorphMany
    {
        return $this->morphMany(DetalleVenta::class, 'itemable');
    }

    /* public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'id', 'id');
    } */
}
