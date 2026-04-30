<?php

namespace App\Models\Formulario\RecienNacido;


use App\Models\Formulario\FormularioInstancia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Formulario\HojaEnfermeria\HojaTerapiaIV;
use App\Models\Formulario\HojaEnfermeria\HojaSignos;     
use App\Models\Formulario\HojaEnfermeria\HojaMedicamento;
use App\Models\Formulario\RecienNacido\Somatometria;
use App\Models\Formulario\RecienNacido\Ingresos_Egresos_RN;


/**
 * @property int $id
 * @property string $area
 * @property string|null $observaciones
 * @property string $nombre_rn
 * @property string $sexo
 * @property \Illuminate\Support\Carbon $fecha_rn
 * @property string $hora_rn
 * @property float $peso
 * @property int $talla
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read FormularioInstancia $formularioInstancia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HojaSignos> $hojaSignos
 * @property-read int|null $hoja_signos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HojaMedicamento> $hojamedicamentos
 * @property-read int|null $hojamedicamentos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HojaTerapiaIV> $hojasTerapiaIV
 * @property-read int|null $hojas_terapia_i_v_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Ingresos_Egresos_RN> $ingresos_egresos
 * @property-read int|null $ingresos_egresos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Somatometria> $somatometrias
 * @property-read int|null $somatometrias_count
 * @property-read mixed $tipo_modelo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereFechaRn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereHoraRn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereNombreRn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecienNacido whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RecienNacido extends Model
{
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'area',
        'nombre_rn',
        'sexo',
        'fecha_rn',
        'hora_rn',
        'peso',
        'talla',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'habitus_exterior' => 'array',
        'fecha_rn' => 'date',
    ];

    protected $appends = [
        'tipo_modelo'
    ];

    public function tipoModelo(): Attribute
    {
        return Attribute::make(
            get: fn() => get_class($this),
        );
    }

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id');
    }
   public function hojamedicamentos() {
        return $this->morphMany(HojaMedicamento::class, 'medicable');
    }

    public function hojasTerapiaIV() {
        return $this->morphMany(HojaTerapiaIV::class, 'terapiable');
    }

    public function hojaSignos():MorphMany
    {
    return $this->morphMany(HojaSignos::class, 'registrable');
    }
    public function somatometrias(): HasMany 
    {
        return $this->hasMany(Somatometria::class, 'hoja_enfermeria_id', 'id'); 
    }
    public function ingresos_egresos(): HasMany
    {
        return $this->hasMany(Ingresos_Egresos_RN::class, 'hoja_enfermeria_id');
    }
}