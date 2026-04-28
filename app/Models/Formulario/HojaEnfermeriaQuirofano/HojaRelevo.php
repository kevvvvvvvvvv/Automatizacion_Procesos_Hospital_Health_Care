<?php

namespace App\Models\Formulario\HojaEnfermeriaQuirofano;

use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

/**
 * @property int $id
 * @property int $hoja_enfermeria_quirofano_id
 * @property int $user_id
 * @property string $hora_entrada
 * @property string|null $hora_salida
 * @property string|null $observaciones_entrega
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read HojaEnfermeria $hojaEnfermeriaQuirofano
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereHojaEnfermeriaQuirofanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereHoraEntrada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereHoraSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereObservacionesEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRelevo whereUserId($value)
 * @mixin \Eloquent
 */
class HojaRelevo extends Model
{
    protected $fillable = [ 
        'hoja_enfermeria_quirofano_id',
        'user_id',
        'hora_entrada',
        'hora_salida',
        'observaciones_entrega',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hojaEnfermeriaQuirofano(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

    
}
