<?php

namespace App\Models\Formulario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Estancia;
use App\Models\User;
use App\Models\Formulario\HojaFrontal\HojaFrontal;
use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use App\Models\Formulario\Interconsulta\Interconsulta;
use App\Models\Formulario\Traslado\Traslado;
use App\Models\Formulario\Preoperatoria\Preoperatoria;
use App\Models\Formulario\NotaPostoperatoria\NotaPostoperatoria;
use App\Models\Estudio\SolicitudPatologia;
use App\Models\Formulario\NotaEgreso\NotaEgreso;
use App\Models\Formulario\NotaEvolucion\NotaEvolucion;
use App\Models\Formulario\NotaUrgencia\NotaUrgencia;
use App\Models\Formulario\NotaPreAnestesica\NotaPreAnestesica;
use App\Models\Formulario\HojaEnfermeriaQuirofano\HojaEnfermeriaQuirofano;
use App\Models\Encuestas\EncuestaSatisfaccion;
use App\Models\Encuestas\EncuestaPersonal;

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

    public function catalogo(): BelongsTo
    {
        return $this->belongsTo(FormularioCatalogo::class, 'formulario_catalogo_id');
    }

    public function hojaFrontal(): HasOne
    {
        return $this->hasOne(HojaFrontal::class, 'id', 'id');
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
        return $this->hasmany(NotaEvolucion::class, 'id', 'id');
    }

    public function hojaEnfermeriaQuirofano(): HasOne
    {
        return $this->hasOne(HojaEnfermeriaQuirofano::class, 'id', 'id');
    }

    public function encuestaSatisfaccion(): HasOne
    {
        return $this->hasOne(EncuestaSatisfaccion::class, 'id', 'id');
    }
    public function encuestaPersonal(): HasOne
    {
        return $this->hasOne(EncuestaPersonal::class, 'id', 'id');
    }
}
