<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $curp
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $sexo
 * @property Carbon $fecha_nacimiento
 * @property string $calle
 * @property string $numero_exterior
 * @property string|null $numero_interior
 * @property string $colonia
 * @property string $municipio
 * @property string $estado
 * @property string $pais
 * @property string $cp
 * @property string $telefono
 * @property string $estado_civil
 * @property string $ocupacion
 * @property string $lugar_origen
 * @property string|null $nombre_padre
 * @property string|null $nombre_madre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Estancia> $estancias
 * @property-read int|null $estancias_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FamiliarResponsable> $familiarResponsables
 * @property-read int|null $familiar_responsables_count
 * @property-read int|null $age
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereApellidoMaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereApellidoPaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereEstadoCivil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereLugarOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereNombreMadre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereNombrePadre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereNumeroExterior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereNumeroInterior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereOcupacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente wherePais($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paciente whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Paciente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'curp',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'fecha_nacimiento',
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'municipio',
        'estado',
        'pais',
        'cp',
        'telefono',
        'estado_civil',
        'ocupacion',
        'lugar_origen',
        'nombre_padre',
        'nombre_madre',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date:Y-m-d', 
    ];

    protected $appends = ['age']; 

    public function getAgeAttribute(): ?int
    {
         return $this->fecha_nacimiento
        ? Carbon::parse($this->fecha_nacimiento)->age
        : null;
    }

    public function estancias(): HasMany
    {
        return $this->hasMany(Estancia::class);
    }

    public function familiarResponsables(): HasMany
    {
        return $this->hasMany(FamiliarResponsable::class);
    }
}