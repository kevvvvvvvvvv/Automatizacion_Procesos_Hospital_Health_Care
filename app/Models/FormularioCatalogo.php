<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioCatalogo extends Model
{
    public const ID_HOJA_FRONTAL = 1;
    public const ID_HISTORIA_CLINICA = 2;
    public const ID_INTERCONSULTA = 3;
    public const ID_HOJA_ENFERMERIA = 4;
    public const ID_TRASLADO = 5;
    public const ID_NOTA_PREOPERATORIA = 6;
    public const ID_NOTA_POSTOPERATOIRA = 7;
    public const ID_NOTA_URGENCIAS = 8;
    public const ID_SOLICITUD_PATOLOGIAS = 9;
    public const ID_NOTA_EGRESO = 10;
    //public const ID_NOTA_EVOLUCION = 11;

    public $incrementing = false; 
    protected $keyType = 'int';
    protected $table = 'formulario_catalogos';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nombre_formulario',
        'nombre_tabla_fisica',
    ];
}
