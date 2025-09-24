<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'curpp';

    protected $fillable = [
        'curpp',
        'nombre',
        'apellidop',
        'apellidom',
        'sexo',
        'fechaNacimiento',
        'calle',
        'numeroExterior',
        'numeroInterior',
        'colonia',
        'municipio',
        'estado',
        'pais',
        'cp',
        'telefono',
        'estadoCivil',
        'ocupacion',
        'lugarOrigen',
        'nombrePadre',
        'nombreMadre',
    ];
}
