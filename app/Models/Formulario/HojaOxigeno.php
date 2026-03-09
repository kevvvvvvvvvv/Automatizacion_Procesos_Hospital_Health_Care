<?php

namespace App\Models\Formulario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User;

/**
 * @property int $id
 * @property string $itemable_type
 * @property int $itemable_id
 * @property int $user_id_inicio
 * @property int|null $user_id_fin
 * @property string $hora_inicio
 * @property string|null $hora_fin
 * @property string $litros_minuto
 * @property-read Model|\Eloquent $itemable
 * @property-read mixed $total_consumido
 * @property-read User|null $userFin
 * @property-read User $userInicio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereHoraFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereItemableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereItemableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereLitrosMinuto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereUserIdFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaOxigeno whereUserIdInicio($value)
 * @mixin \Eloquent
 */
class HojaOxigeno extends Model
{
    protected $fillable = [
        'id',
        'itemable_type',
        'itemable_id',
        'user_id_inicio',
        'user_id_fin',
        'hora_inicio',
        'hora_fin',
        'litros_minuto',
    ];

    public $timestamps = false;

    protected $appends = ['total_consumido'];

    public function itemable()
    {
        return $this->morphTo();
    }

    public function userInicio():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_inicio', 'id');
    }

    public function userFin(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id_fin','id');
    }

    protected function totalConsumido(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if (empty($attributes['hora_fin'])) {
                    return null; 
                }

                $inicio = Carbon::parse($attributes['hora_inicio']);
                $fin = Carbon::parse($attributes['hora_fin']);
                $minutos = $inicio->floatDiffInMinutes($fin);
                return round($minutos * $attributes['litros_minuto'], 2);
            }
        );
    }
}
