<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Venta\DetalleVenta;
use App\Models\Estudio\CatalogoEstudio;

class ProductoServicio extends Model
{
    public const IVA = .16;
    public const comision_terminal = 0.04176;

    protected $table = 'producto_servicios';
    public $incrementing = true;

    protected $fillable = [
        'id',
        'tipo',
        'subtipo',
        'codigo_prestacion',
        'nombre_prestacion',
        'importe',
        'cantidad',
        'iva',
        'cantidad_maxima',
        'cantidad_minima',
        'fecha_caducidad',
        'proveedor'
    ];

    public function detallesVenta()
    {
        return $this->morphMany(DetalleVenta::class, 'itemable');
    }

    public function medicamento(): HasOne
    {
        return $this->hasOne(Medicamento::class, 'id', 'id');
    }

    public function insumo(): HasOne
    {
        return $this->hasOne(Insumo::class, 'id','id');
    }

    public function estudio(): HasOne
    {
        return $this->hasOne(CatalogoEstudio::class, 'id', 'id');
    }
    
    public function getListaViasAttribute()
    {
        if ($this->medicamento && $this->medicamento->viasAdministracion) {
            return $this->medicamento->viasAdministracion;
        }
        
        return collect([]); 
    }
}
 