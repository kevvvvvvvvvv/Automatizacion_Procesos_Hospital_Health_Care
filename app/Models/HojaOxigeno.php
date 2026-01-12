<?php

namespace App\Models;

use App\Http\Controllers\EstanciaController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

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
