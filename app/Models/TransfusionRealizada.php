<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransfusionRealizada extends Model
{
    protected $table = 'transfusion_realizadas';

    protected $fillable = [
        'id',
        'nota_postoperatoria_id',
        'tipo_transfusion',
        'cantidad',
    ];

    public function notaPostoperatoria(): BelongsTo
    {
        return $this->belongsTo(NotaPostoperatoria::class, 'nota_postoperatoria_id', 'id');
    }    

}
