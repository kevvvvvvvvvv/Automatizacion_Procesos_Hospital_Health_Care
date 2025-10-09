<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductoServicio extends Model
{
    protected $table = 'producto_servicios';
    public $incrementing = true;

    protected $fillable = [
        'tipo',
        'subtipo',
        'codigo_prestacion',
        'nombre_prestacion',
        'importe',
        'cantidad',
    ];

    public $timestamps = false;

    public function detalleVenta(): HasOne
    {
        return $this->hasOne(DetalleVenta::class);
    }

}
