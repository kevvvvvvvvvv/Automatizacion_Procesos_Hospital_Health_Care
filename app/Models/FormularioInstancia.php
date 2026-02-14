<?php

namespace App\Models;

use App\Models\Encuestas\EncuestaSatisfaccion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $fecha_hora
 * @property int $estancia_id
 * @property int $formulario_catalogo_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioCatalogo $catalogo
 * @property-read \App\Models\Estancia $estancia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SolicitudPatologia> $estudioPatologia
 * @property-read int|null $estudio_patologia_count
 * @property-read \App\Models\HojaEnfermeria|null $hojaEnfermeria
 * @property-read \App\Models\HojaEnfermeriaQuirofano|null $hojaEnfermeriaQuirofano
 * @property-read \App\Models\HojaFrontal|null $hojaFrontal
 * @property-read \App\Models\Interconsulta|null $interconsulta
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotaEvolucion> $notaEvolucion
 * @property-read int|null $nota_evolucion_count
 * @property-read \App\Models\NotaUrgencia|null $notaUrgencia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotaPostoperatoria> $postoperatoria
 * @property-read int|null $postoperatoria_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Preoperatoria> $preoperatoria
 * @property-read int|null $preoperatoria_count
 * @property-read \App\Models\Traslado|null $traslado
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia whereEstanciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia whereFechaHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia whereFormularioCatalogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioInstancia whereUserId($value)
 * @property-read EncuestaSatisfaccion|null $encuestaSatisfaccion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotaEgreso> $notaEgreso
 * @property-read int|null $nota_egreso_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotaPreAnestesica> $notaPreAnestesica
 * @property-read int|null $nota_pre_anestesica_count
 * @mixin \Eloquent
 */
class FormularioInstancia extends Model
{
    protected $table = 'formulario_instancias';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'fecha_hora',
        'estancia_id',
        'formulario_catalogo_id',
        'user_id'
    ];

    public function estancia():BelongsTo
    {
        return $this->belongsTo(Estancia::class,'estancia_id', 'id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function hojaFrontal(): HasOne
    {
        return $this->hasOne(HojaFrontal::class, 'id', 'id');
    }

    public function catalogo(): BelongsTo
    {
        return $this->belongsTo(FormularioCatalogo::class, 'formulario_catalogo_id');
    }

    public function hojaEnfermeria(): HasOne
    {
        return $this->hasOne(HojaEnfermeria::class,'id','id');
    }

    public function interconsulta(): HasOne
    {
        return $this->hasOne(Interconsulta::class,'id','id');
    }

    public function traslado(): HasOne
    {
        return $this->hasOne(Traslado::class,'id','id');
    }

    public function preoperatoria(): HasMany
    {
        return $this->hasMany(Preoperatoria::class,'id','id');
    }

    public function postoperatoria(): HasMany
    {
        return $this->hasMany(NotaPostoperatoria::class, 'id','id');
    }

    public function notaUrgencia(): HasOne
    {
        return $this->hasOne(NotaUrgencia::class,'id','id');
    }
    
    public function estudioPatologia(): HasMany
    {
        return $this->hasMany(SolicitudPatologia::class, 'id', 'id');
    }
    public function notaEgreso(): HasMany
    {
        return $this->hasMany(NotaEgreso::class,'id', 'id');
    }
    public function notaPreAnestesica(): HasMany
    {
        return $this->hasmany(NotaPreAnestesica::class, 'id', 'id');
    }
    public function notaEvolucion(): HasMany
    {
        return $this->hasmany(notaEvolucion::class, 'id', 'id');
    }

    public function hojaEnfermeriaQuirofano(): HasOne
    {
        return $this->hasOne(HojaEnfermeriaQuirofano::class, 'id', 'id');
    }

    public function encuestaSatisfaccion(): HasOne
    {
        return $this->hasOne(EncuestaSatisfaccion::class, 'id', 'id');
    }
}
