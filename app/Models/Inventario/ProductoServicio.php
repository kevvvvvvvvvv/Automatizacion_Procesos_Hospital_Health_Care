<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Venta\DetalleVenta;
use App\Models\Estudio\CatalogoEstudio;

/**
 * @property int $id
 * @property string $tipo
 * @property string $subtipo
 * @property string|null $codigo_prestacion
 * @property string|null $codigo_barras
 * @property string $nombre_prestacion
 * @property string $importe
 * @property string|null $importe_compra
 * @property int|null $cantidad
 * @property int|null $cantidad_maxima
 * @property int|null $cantidad_minima
 * @property string|null $proveedor
 * @property string|null $fecha_caducidad
 * @property string $iva
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DetalleVenta> $detallesVenta
 * @property-read int|null $detalles_venta_count
 * @property-read CatalogoEstudio|null $estudio
 * @property-read mixed $lista_vias
 * @property-read \App\Models\Inventario\Insumo|null $insumo
 * @property-read \App\Models\Inventario\Medicamento|null $medicamento
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCantidadMaxima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCantidadMinima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCodigoBarras($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCodigoPrestacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereFechaCaducidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereImporte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereImporteCompra($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereNombrePrestacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereProveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereSubtipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductoServicio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductoServicio extends Model
{
    public const IVA = 1.16;

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
