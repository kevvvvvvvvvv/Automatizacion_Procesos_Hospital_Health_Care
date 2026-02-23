<?php

namespace App\Models\Estudio;

use App\Models\SolicitudItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudItemArchivo extends Model
{
    protected $fillable = [ 
        'id',
        'ruta_archivo_resultado',
        'solicitud_item_id',
    ];

    public function solicitudItem():BelongsTo
    {
        return $this->belongsTo(SolicitudItem::class);
    }
}
