<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $identificador
 * @property string $tipo
 * @property string $ubicacion
 * @property string $estado
 * @property string $piso
 * @property-read \App\Models\Estancia|null $estanciaActiva
 * @property-read \App\Models\Estancia|null $estancias
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HabitacionPrecio> $habitacionPrecios
 * @property-read int|null $habitacion_precios_count
 * @property-read \App\Models\Paciente|null $paciente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion whereIdentificador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion wherePiso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habitacion whereUbicacion($value)
 * @mixin \Eloquent
 */
class Habitacion extends Model
{
    protected $table = 'habitaciones';
    public $incrementing = true;
    
    protected $fillable = [
        'identificador',
        'tipo',
        'ubicacion',
        'estado',
        'piso',
    ];

    public $timestamps = false;

    public function estancias():HasOne
    {
        return $this->hasOne(Estancia::class, 'habitacion_id');
    }

    public function estanciaActiva()
    {
        return $this->hasOne(Estancia::class)
                    ->where('tipo_estancia', 'Hospitalizacion') 
                    ->whereNull('fecha_egreso');              
    }

    public function habitacionPrecios(): HasMany 
    {
        return $this->hasMany(HabitacionPrecio::class);
    }


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
