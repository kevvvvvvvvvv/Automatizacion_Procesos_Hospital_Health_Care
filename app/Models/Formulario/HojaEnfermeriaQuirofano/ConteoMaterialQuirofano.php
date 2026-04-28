<?php

namespace App\Models\Formulario\HojaEnfermeriaQuirofano;

use Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $hoja_enfermeria_quirofano_id
 * @property string $tipo_material
 * @property int $cantidad_inicial
 * @property int $cantidad_agregada
 * @property int $cantidad_final
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $tipo_material_leible
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereCantidadAgregada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereCantidadFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereCantidadInicial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereHojaEnfermeriaQuirofanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereTipoMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConteoMaterialQuirofano whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ConteoMaterialQuirofano extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_quirofano_id',
        'tipo_material',
        'cantidad_inicial',
        'cantidad_agregada',
        'cantidad_final'
    ];

    public function getTipoMaterialLeibleAttribute()
    {
        $opciones = [
            'gasas_con_trama' => 'Gasas con trama',
            'compresas' => 'Compresas',
            'puchitos' => 'Puchitos',
            'cotonoides' => 'Cotonoides',
            'agujas' => 'Agujas',
        ];

        return $opciones[$this->tipo_material] ?? $this->tipo_material;
    }
}
