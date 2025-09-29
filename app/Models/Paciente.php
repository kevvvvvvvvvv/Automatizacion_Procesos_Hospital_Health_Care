<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 2. Nombres de columnas actualizados a snake_case para coincidir con la migración.
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

    /**
     * Define la relación: un paciente puede tener muchas estancias.
     */
    public function estancias(): HasMany
    {
        return $this->hasMany(Estancia::class);
    }
}