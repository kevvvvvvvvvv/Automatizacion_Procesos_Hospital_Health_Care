<?php

namespace App\Models\Formulario\HojaEnfermeria; 
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Inventario\ProductoServicio;
use App\Models\Formulario\HojaEnfermeria\HojaTerapiaIVMedicamento;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property int $solucion
 * @property int $cantidad
 * @property string $duracion
 * @property string $flujo_ml_hora
 * @property string|null $fecha_hora_inicio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ProductoServicio $detalleSoluciones
 * @property-read \App\Models\Formulario\HojaEnfermeria\HojaEnfermeria $hojaEnfermeria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereDuracion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereFechaHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereFlujoMlHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereSolucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaTerapiaIV whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaTerapiaIV extends Model
{
    protected $table = 'hoja_terapias';
    
    protected $fillable = [
        
        'terapiable_id',
        'terapiable_type',
        'solucion',
        'nombre_solucion',
        'cantidad',
        'duracion',
        'flujo_ml_hora',
        'fecha_hora_inicio',
    ];
    public function terapiable() { 
        return $this->morphTo(); 
    }

    public function detalleSoluciones():BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'solucion','id');
    }

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

    public function medicamentos(): HasMany
    {
        return $this->hasMany(HojaTerapiaIVMedicamento::class,'hoja_terapia_id');
    }
    public function recienNacido(): BelongsTo 
    {
        return $this->belongsTo(RecienNacido::class, 'hoja_enfermeria_id', 'id');
    }
    
}
