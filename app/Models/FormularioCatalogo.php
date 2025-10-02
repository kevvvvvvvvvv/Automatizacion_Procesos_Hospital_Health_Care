<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioCatalogo extends Model
{
    public $incrementing = true; 
    protected $keyType = 'int';
    protected $table = 'formulario_catalogos';
    public $timestamps = false;

    protected $fillable = [
        'nombre_formulario',
        'nombre_tabla_fisica',
    ];
}
