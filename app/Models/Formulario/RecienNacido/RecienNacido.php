<?php

namespace App\Models\Formulario\RecienNacido;


use App\Models\Formulario\FormularioInstancia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Formulario\HojaEnfermeria\HojaTerapiaIV;
use App\Models\Formulario\HojaEnfermeria\HojaSignos;      // Haz lo mismo con estos
use App\Models\Formulario\HojaEnfermeria\HojaMedicamento;
use App\Models\Formulario\RecienNacido\Somatometria;
use App\Models\Formulario\RecienNacido\Ingresos_Egresos_RN;

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


    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id');
    }
    public function hojaSignos(): HasMany 
    {
        return $this->hasMany(HojaSignos::class, 'hoja_enfermeria_id', 'id');
    }

    public function hojaMedicamentos(): HasMany 
    {
        return $this->hasMany(HojaMedicamento::class, 'hoja_enfermeria_id', 'id');
    }

    public function hojasTerapiasIV(): HasMany 
    {
        return $this->hasMany(HojaTerapiaIV::class, 'hoja_enfermeria_id', 'id');
    }
    public function somatometrias(): HasMany 
    {
        return $this->hasMany(Somatometria::class, 'id', 'id'); 
    }
    public function Ingresos_Egresos_RN(): HasMany
    {
        return $this->hasMany(Ingresos_Egresos_RN::class, 'hoja_enfermeria_id');
    }
}