<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insumo extends Model
{
    protected $table = 'insumos';

    // Desactivamos el autoincremento porque heredamos el ID
    public $incrementing = false;

    protected $fillable = [
        'id',
        'categoria',
        'especificacion',
        'categoria_unitaria',
    ];

    /**
     * Relación inversa con el Producto/Servicio principal.
     */
    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'id');
    }
}