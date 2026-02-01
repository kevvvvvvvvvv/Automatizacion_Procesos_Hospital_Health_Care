<?php

namespace App\Models;

use Faker\Extension\PersonExtension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string|null $hora_inicio_cirugia
 * @property string|null $hora_inicio_anestesia
 * @property string|null $hora_inicio_paciente
 * @property string|null $hora_fin_cirugia
 * @property string|null $hora_fin_anestesia
 * @property string|null $hora_fin_paciente
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaInsumosBasicos> $hojaInsumosBasicos
 * @property-read int|null $hoja_insumos_basicos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaOxigeno> $hojaOxigenos
 * @property-read int|null $hoja_oxigenos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalEmpleado> $personalEmpleados
 * @property-read int|null $personal_empleados_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereHoraFinAnestesia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereHoraFinCirugia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereHoraFinPaciente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereHoraInicioAnestesia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereHoraInicioCirugia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereHoraInicioPaciente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereUpdatedAt($value)
 * @property array<array-key, mixed>|null $anestesia
 * @property array<array-key, mixed>|null $servicios_especiales
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereAnestesia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeriaQuirofano whereServiciosEspeciales($value)
 * @mixin \Eloquent
 */
class HojaEnfermeriaQuirofano extends Model
{
    
    public $incrementing = false;
    protected $fillable = [
        'id',

        'anestesia',
        'servicios_especiales',

        'hora_inicio_cirugia',
        'hora_inicio_anestesia',
        'hora_inicio_paciente',
        'hora_fin_cirugia',
        'hora_fin_anestesia',
        'hora_fin_paciente'
    ];

    protected $casts = [
        'anestesia' => 'array',
        'servicios_especiales' => 'array'
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    public function hojaInsumosBasicos(): HasMany
    {
        return $this->hasMany(HojaInsumosBasicos::class);
    }

    public function personalEmpleados()
    {
        return $this->morphMany(PersonalEmpleado::class, 'itemable');
    }

    public function hojaOxigenos(): MorphMany
    {
        return $this->morphMany(HojaOxigeno::class, 'itemable');
    }

}
