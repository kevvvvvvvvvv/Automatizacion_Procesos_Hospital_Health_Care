<?php

namespace App\Models\Encuestas;

use App\Models\FormularioInstancia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read FormularioInstancia|null $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion query()
 * @mixin \Eloquent
 */
class EncuestaSatisfaccion extends Model
{
    protected $fillable = [
            'id',
            'atencion_recpcion',
            'trato_personal_enfermeria',
            'limpieza_comodidad_habitacion',
            'calidad_comida',
            'tiempo_atencion',
            'informacion_tratamiento',
            'atencion_nutricional',
            'comentarios',
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

}
