<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogoEstudio extends Model
{
    
    protected $fillable = [
        'id',
        'nombre',
        'tipo_estudio',
        'departamento',
        'tiempo_entrega',
        'costo',
    ];

    public function solicitudItem(): HasMany
    {
        return $this->hasMany(SolicitudItem::class);
    }

    public function detallesVenta()
    {
        return $this->morphMany(DetalleVenta::class, 'itemable');
    }
}
