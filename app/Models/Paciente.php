<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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