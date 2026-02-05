<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Inventario\Medicamento;
use App\Models\Inventario\Insumo;

/**
 * @property int $id
 * @property string $tipo
 * @property string $subtipo
 * @property string $codigo_prestacion
 * @property string $nombre_prestacion
 * @property string $importe
 * @property int|null $cantidad
 * @property string $iva
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetalleVenta> $detallesVenta
 * @property-read int|null $detalles_venta_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCodigoPrestacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereImporte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereNombrePrestacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereSubtipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereTipo($value)
 * @property string|null $codigo_barras
 * @property string|null $importe_compra
 * @property int|null $cantidad_maxima
 * @property int|null $cantidad_minima
 * @property string|null $proveedor
 * @property string|null $fecha_caducidad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCantidadMaxima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCantidadMinima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCodigoBarras($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereFechaCaducidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereImporteCompra($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereProveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereUpdatedAt($value)
 * @property-read mixed $vias_administracion
 * @property-read Medicamento|null $medicamento
 * @property-read mixed $lista_vias
 * @mixin \Eloquent
 */
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
    
    public function getListaViasAttribute()
    {
        if ($this->medicamento && $this->medicamento->viasAdministracion) {
            return $this->medicamento->viasAdministracion;
        }
        
        return collect([]); 
    }
}
