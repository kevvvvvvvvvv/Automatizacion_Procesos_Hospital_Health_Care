<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductoServicio extends Model
{
    public const IVA = 1.16;

    protected $table = 'producto_servicios';
    public $incrementing = true;

    protected $fillable = [
        'tipo',
        'subtipo',
        'codigo_prestacion',
        'nombre_prestacion',
        'importe',
        'cantidad',
        'iva'
    ];

    public $timestamps = false;

    public function detallesVenta()
    {
        return $this->morphMany(DetalleVenta::class, 'itemable');
    }

}
