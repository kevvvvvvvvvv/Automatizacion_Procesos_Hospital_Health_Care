<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Auditable;

/**
 * @property int $id
 * @property string $folio
 * @property int $paciente_id
 * @property string $fecha_ingreso
 * @property string|null $fecha_egreso
 * @property int|null $habitacion_id
 * @property string $tipo_estancia
 * @property string $modalidad_ingreso
 * @property int|null $estancia_anterior_id
 * @property int|null $familiar_responsable_id
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Consentimiento> $Consentimiento
 * @property-read int|null $consentimiento_count
 * @property-read \App\Models\User $creator
 * @property-read Estancia|null $estanciaAnterior
 * @property-read \App\Models\FamiliarResponsable|null $familiarResponsable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FormularioInstancia> $formularioInstancias
 * @property-read int|null $formulario_instancias_count
 * @property-read \App\Models\Habitacion|null $habitacion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaOxigeno> $hojaOxigenos
 * @property-read int|null $hoja_oxigenos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Interconsulta> $interconsultas
 * @property-read int|null $interconsultas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotaEvolucion> $notasEvoluciones
 * @property-read int|null $notas_evoluciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotaPostoperatoria> $notasPostoperatorias
 * @property-read int|null $notas_postoperatorias_count
 * @property-read \App\Models\Paciente $paciente
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Estancia> $reingresos
 * @property-read int|null $reingresos_count
 * @property-read \App\Models\User|null $updater
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Venta> $ventas
 * @property-read int|null $ventas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereEstanciaAnteriorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereFamiliarResponsableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereFechaEgreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereFolio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereHabitacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereModalidadIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia wherePacienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereTipoEstancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estancia whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Estancia extends Model
{
    use HasFactory, Auditable;

    protected $table = 'estancias';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'fecha_ingreso',
        'fecha_egreso',
        'habitacion_id',
        'tipo_estancia',
        'tipo_ingreso',
        'modalidad_ingreso',
        'paciente_id',
        'estancia_anterior_id',
        'familiar_responsable_id',
        'created_by', 
        'updated_by'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function estanciaAnterior(): BelongsTo
    {
        return $this->belongsTo(Estancia::class, 'estancia_anterior_id');
    }

    public function reingresos(): HasMany
    {
        return $this->hasMany(Estancia::class, 'estancia_anterior_id'); 
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function formularioInstancias(): HasMany
    {
        return $this->hasMany(FormularioInstancia::class);
    }

    public function familiarResponsable():BelongsTo
    {
        return $this->belongsTo(FamiliarResponsable::class,'familiar_responsable_id');
    }

    public function habitacion():BelongsTo
    {
        return $this->belongsTo(Habitacion::class,'habitacion_id');
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }

    public function interconsultas()
    {
        return $this->hasMany(Interconsulta::class);
    }

    public function notasPostoperatorias(): HasManyThrough
    {
        return $this->hasManyThrough(
            NotaPostoperatoria::class, 
            FormularioInstancia::class, 
            'estancia_id',              
            'id',                       
            'id',                       
            'id'                        
        );
    }

    public function notasEvoluciones(): HasManyThrough
    {
        return $this->hasManyThrough(
            NotaEvolucion::class,
            FormularioInstancia::class,
            'estancia_id',
            'id',
            'id',
            'id'

        );
    }

    public function hojaOxigenos(): HasMany
    {
        return $this->hasMany(HojaOxigeno::class);
    }
    public function Consentimiento():hasMany
    {
        return $this->hasMany(Consentimiento::class);
    } 
}
