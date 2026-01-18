<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $habitacion_id
 * @property int $user_id
 * @property int|null $estancia_id
 * @property string|null $paciente
 * @property string $tratante
 * @property string $procedimiento
 * @property string $tiempo_estimado
 * @property string $medico_operacion
 * @property string|null $laparoscopia_detalle
 * @property string|null $instrumentista
 * @property string|null $anestesiologo
 * @property string|null $insumos_medicamentos
 * @property string|null $esterilizar_detalle
 * @property string|null $rayosx_detalle
 * @property string|null $patologico_detalle
 * @property string|null $comentarios
 * @property array<array-key, mixed> $horarios
 * @property \Illuminate\Support\Carbon $fecha
 * @property string|null $localizacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Habitacion|null $habitacion
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereAnestesiologo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereComentarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereEstanciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereEsterilizarDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereHabitacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereHorarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereInstrumentista($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereInsumosMedicamentos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereLaparoscopiaDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereLocalizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereMedicoOperacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano wherePaciente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano wherePatologicoDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereProcedimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereRayosxDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereTiempoEstimado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereTratante($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionQuirofano whereUserId($value)
 * @mixin \Eloquent
 */
class ReservacionQuirofano extends Model
{
    // Esto permite que el método fill($data) funcione
    protected $fillable = [
        'paciente',
        'paciente_id',
        'estancia_id',
        'procedimiento',
        'tratante',
        'tiempo_estimado',
        'medico_operacion',
        'fecha',
        'horarios',
        'localizacion',
        'habitacion_id',
        'user_id',
        'comentarios',
        'instrumentista',
        'anestesiologo',
        'insumos_medicamentos',
        'esterilizar_detalle',
        'rayosx_detalle',
        'patologico_detalle',
        'laparoscopia_detalle'
    ];

    // No olvides los casts para los horarios
    protected $casts = [
        'horarios' => 'array',
        'fecha' => 'date'
    ];

    // Relaciones
    public function user() { return $this->belongsTo(User::class); }
    public function habitacion() { return $this->belongsTo(Habitacion::class); }
}   