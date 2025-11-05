<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->hasOne(Translado::class,'id','id');
    }
}
