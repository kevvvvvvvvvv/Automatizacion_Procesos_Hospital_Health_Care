<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioCatalogo extends Model
{
    public const ID_HOJA_FRONTAL = 1;
    public const ID_HISTORIA_CLINICA = 2;
    public const ID_INTERCONSULTA = 3;
    public const ID_HOJA_ENFERMERIA = 4;

    public $incrementing = true; 
    protected $keyType = 'int';
    protected $table = 'formulario_catalogos';
    public $timestamps = false;

    protected $fillable = [
        'nombre_formulario',
        'nombre_tabla_fisica',
    ];
}
