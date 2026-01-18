<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $interconsulta_id
 * @property numeric $monto
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Interconsulta $interconsulta
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario whereInterconsultaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Honorario whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Honorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'interconsulta_id',
        'monto',
        'descripcion',
    ];

    protected $casts = [
        'monto' => 'decimal:2', 
    ];

    // Relación con Interconsulta
    public function interconsulta()
    {
        return $this->belongsTo(Interconsulta::class);
    }
}