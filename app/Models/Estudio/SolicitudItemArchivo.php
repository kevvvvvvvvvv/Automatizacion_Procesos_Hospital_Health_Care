<?php

namespace App\Models\Estudio;

use App\Models\SolicitudItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string|null $ruta_archivo_resultado
 * @property int $solicitud_item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read SolicitudItem $solicitudItem
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo whereRutaArchivoResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo whereSolicitudItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudItemArchivo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SolicitudItemArchivo extends Model
{
    protected $fillable = [ 
        'id',
        'ruta_archivo_resultado',
        'nombre_archivo',
        'solicitud_item_id',
    ];

    public function solicitudItem():BelongsTo
    {
        return $this->belongsTo(SolicitudItem::class);
    }
}
