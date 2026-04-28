<?php

namespace App\Models\Formulario\Paquete;

use App\Models\Estudio\SolicitudEstudio;
use App\Models\Formulario\FormularioInstancia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $formulario_instancia_id
 * @property int $solicitud_estudio_id
 * @property int|null $catalogo_estudio_id
 * @property string|null $otro_estudio
 * @property string $departamento_destino
 * @property string|null $ta_sistolica
 * @property string|null $ta_diastolica
 * @property string|null $fc
 * @property string|null $fr
 * @property string|null $temp
 * @property string|null $so2
 * @property string|null $glucemia
 * @property string|null $peso
 * @property string|null $talla
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Estudio\CatalogoEstudio|null $catalogoEstudio
 * @property-read mixed $nombre_final
 * @property-read SolicitudEstudio $solicitudEstudio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereCatalogoEstudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereDepartamentoDestino($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereFormularioInstanciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereGlucemia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereOtroEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereSo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereSolicitudEstudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereTaDiastolica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereTaSistolica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paquete whereUpdatedAt($value)
 * @property-read FormularioInstancia|null $formularioInstancia
 * @mixin \Eloquent
 */
class Paquete extends Model
{
    // Esta línea es la que permite que el Controller guarde los datos
    protected $fillable = [
        'formulario_instancia_id', // <--- ¡ASEGÚRATE QUE ESTE ESTÉ AQUÍ!
        'solicitud_estudio_id',
        'catalogo_estudio_id',
        'otro_estudio',
        'departamento_destino',
        'estado',
        'ta_sistolica',
        'ta_diastolica',
        'fc',
        'fr',
        'temp',
        'so2',
        'glucemia',
        'peso',
        'talla',
    ];


    /**
     * Relación inversa con la solicitud
     */
    public function solicitudEstudio(): BelongsTo
    {
        return $this->belongsTo(SolicitudEstudio::class);
    }

    /**
     * Relación con el catálogo (si existe)
     */
  public function catalogoEstudio()
{
    return $this->belongsTo(\App\Models\Estudio\CatalogoEstudio::class, 'catalogo_estudio_id');
}
    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    } 

    /**
     * Accesor para obtener el nombre final del estudio
     */
    public function getNombreFinalAttribute()
    {
        return $this->catalogo_estudio_id 
            ? $this->catalogoEstudio->nombre 
            : $this->otro_estudio;
    }
}