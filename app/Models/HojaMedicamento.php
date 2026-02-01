<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductoServicio;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property int $producto_servicio_id
 * @property int $dosis
 * @property string $gramaje
 * @property string $unidad
 * @property string $via_administracion
 * @property int $duracion_tratamiento
 * @property string|null $fecha_hora_inicio
 * @property string $estado
 * @property string $fecha_hora_solicitud
 * @property string|null $fecha_hora_surtido_farmacia
 * @property int|null $farmaceutico_id
 * @property string|null $fecha_hora_recibido_enfermeria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AplicacionMedicamento> $aplicaciones
 * @property-read int|null $aplicaciones_count
 * @property-read \App\Models\HojaEnfermeria $hojaEnfermeria
 * @property-read ProductoServicio $productoServicio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereDosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereDuracionTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereFarmaceuticoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereFechaHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereFechaHoraRecibidoEnfermeria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereFechaHoraSolicitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereFechaHoraSurtidoFarmacia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereGramaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereProductoServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereUnidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereViaAdministracion($value)
 * @property string $nombre_medicamento
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaMedicamento whereNombreMedicamento($value)
 * @mixin \Eloquent
 */
class HojaMedicamento extends Model
{
    
    protected $table = 'hoja_medicamentos';

    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'producto_servicio_id',
        'dosis',
        'gramaje',
        'unidad',
        'via_administracion',
        'duracion_tratamiento',
        'fecha_hora_inicio',
        'estado',
        'fecha_hora_solicitud',
        'fecha_hora_surtido_farmacia',
        'farmaceutico_id',
        'fecha_hora_recibido_enfermeria',

        'nombre_medicamento'
    ];

    public function productoServicio():BelongsTo
    {   
        return $this->belongsTo(ProductoServicio::class,'producto_servicio_id');
    }

    public function hojaEnfermeria():BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }

    public function aplicaciones()
    {
        return $this->hasMany(AplicacionMedicamento::class)
                    ->orderBy('fecha_aplicacion', 'asc');
    }
}
