<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ParagonIE_Sodium_Core_Ed25519;

/**
 * @property int $id
 * @property string $nombre_formulario
 * @property string $nombre_tabla_fisica
 * @property string $route_prefix
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioCatalogo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioCatalogo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioCatalogo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioCatalogo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioCatalogo whereNombreFormulario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioCatalogo whereNombreTablaFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormularioCatalogo whereRoutePrefix($value)
 * @mixin \Eloquent
 */
class FormularioCatalogo extends Model
{
    /**
     * ID's registrados en la tabla formulario_catalogos
     */
    public const ID_HOJA_FRONTAL = 1;
    public const ID_HISTORIA_CLINICA = 2;
    public const ID_INTERCONSULTA = 3;
    public const ID_HOJA_ENFERMERIA = 4;
    public const ID_TRASLADO = 5;
    public const ID_NOTA_PREOPERATORIA = 6;
    public const ID_NOTA_POSTOPERATOIRA = 7;
    public const ID_NOTA_URGENCIAS = 8;
    public const ID_SOLICITUD_PATOLOGIA = 9;
    public const ID_NOTA_EGRESO = 10;
    public const ID_NOTA_EVOLUCION = 11;
    public const ID_NOTA_PREANESTESICA = 12;
    public const ID_NOTA_POSTANESTESICA = 13;
    public const ID_HOJA_ENFERMERIA_QUIROFANO = 14;
    public const ID_SOLICITUD_ESTUDIOS = 15;
    public const ID_ENCUESTA_SATISFACCION = 16;
    public const ID_ENCUESTA_PERSONAL = 17;

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
