<?php

namespace App\Models\Venta;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $tipo_ajuste
 * @property string $valor_ajuste
 * @property int $activo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago whereTipoAjuste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MetodoPago whereValorAjuste($value)
 * @mixin \Eloquent
 */
class MetodoPago extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'tipo_ajuste',
        'valor_ajuste',
        'activo',
        'created_at',
        'updated_at',
    ];

}
