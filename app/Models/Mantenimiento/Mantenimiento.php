<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Habitacion\Habitacion;
use App\Models\User;

/**
 * @property int $id
 * @property string $tipo_servicio
 * @property string|null $comentarios
 * @property string|null $observaciones
 * @property bool|null $resultado_aceptado
 * @property int $duracion_espera
 * @property int $duracion_actividad
 * @property int $habitacion_id
 * @property int $user_solicita_id
 * @property int|null $user_ejecuta_id
 * @property \Illuminate\Support\Carbon|null $fecha_solicita
 * @property \Illuminate\Support\Carbon|null $fecha_arregla
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $ejecutor
 * @property-read Habitacion $habitacion
 * @property-read User $solicitante
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereComentarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereDuracionActividad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereDuracionEspera($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereFechaArregla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereFechaSolicita($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereHabitacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereResultadoAceptado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereTipoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereUserEjecutaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mantenimiento whereUserSolicitaId($value)
 * @mixin \Eloquent
 */
class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento';

    protected $fillable = [
        'tipo_servicio',
        'comentarios',
        'resultado_aceptado',
        'observaciones',
        'duracion_espera',
        'duracion_actividad',
        'habitacion_id',
        'user_solicita_id',
        'user_ejecuta_id',
        'fecha_solicita', 
        'fecha_arregla'  
    ];

    protected $casts = [
        'fecha_solicita' => 'datetime',
        'fecha_arregla' => 'datetime',
        'resultado_aceptado' => 'boolean',
    ];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'user_solicita_id');
    }

    public function ejecutor()
    {
        return $this->belongsTo(User::class, 'user_ejecuta_id');
    }
}
