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
 * @property int $id
 * @property int $atencion_recpcion
 * @property int $trato_personal_enfermeria
 * @property int $limpieza_comodidad_habitacion
 * @property int $calidad_comida
 * @property int $tiempo_atencion
 * @property int $informacion_tratamiento
 * @property int $atencion_nutricional
 * @property string|null $comentarios
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereAtencionNutricional($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereAtencionRecpcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereCalidadComida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereComentarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereInformacionTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereLimpiezaComodidadHabitacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereTiempoAtencion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereTratoPersonalEnfermeria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaSatisfaccion whereUpdatedAt($value)
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
