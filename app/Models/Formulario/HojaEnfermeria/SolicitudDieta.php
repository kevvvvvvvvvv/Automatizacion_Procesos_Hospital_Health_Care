<?php

namespace App\Models\Formulario\HojaEnfermeria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;
use App\Models\Cocina\Dieta;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property string|null $fecha_hora_programada
 * @property string|null $lugar_entrega
 * @property int $dieta_id
 * @property string $estado
 * @property string $horario_solicitud
 * @property int|null $user_supervisa_id
 * @property string|null $horario_entrega
 * @property int|null $user_entrega_id
 * @property string|null $observaciones
 * @property-read Dieta $dieta
 * @property-read \App\Models\Formulario\HojaEnfermeria\HojaEnfermeria $hojaEnfermeria
 * @property-read User|null $userEntrega
 * @property-read User|null $usuarioSupervisa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereDietaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereFechaHoraProgramada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereHorarioEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereHorarioSolicitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereLugarEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereUserEntregaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudDieta whereUserSupervisaId($value)
 * @mixin \Eloquent
 */
class SolicitudDieta extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'dieta_id',

        'fecha_hora_programada',
        'lugar_entrega',

        'estado',

        'horario_solicitud',
        'user_supervisa_id',
        
        'horario_entrega',
        'user_entrega_id',
        
        'observaciones'
        
    ];

    public $timestamps = false;

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

    public function usuarioSupervisa():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_supervisa_id', 'id');
    }

    public function userEntrega():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_entrega_id', 'id');
    }

    public function dieta():BelongsTo
    {
        return $this->belongsTo(Dieta::class);
    }
}
