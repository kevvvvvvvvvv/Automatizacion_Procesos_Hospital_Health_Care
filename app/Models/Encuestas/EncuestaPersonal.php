<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $trato_claro
 * @property int $presentacion_personal
 * @property int $tiempo_atencion
 * @property int $informacion_tratamiento
 * @property string|null $comentarios
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal whereComentarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal whereInformacionTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal wherePresentacionPersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal whereTiempoAtencion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal whereTratoClaro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EncuestaPersonal extends Model
{
    protected $table = 'encuesta_personal'; 
    public $incrementing = false;

    protected $fillable = [
        'id', 
        'trato_claro', 
        'presentacion_personal', 
        'tiempo_atencion', 
        'informacion_tratamiento', 
        'comentarios'
    ];
}
