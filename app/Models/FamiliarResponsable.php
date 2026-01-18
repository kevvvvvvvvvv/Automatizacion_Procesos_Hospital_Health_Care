<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $parentesco
 * @property string $nombre_completo
 * @property int $paciente_id
 * @property-read \App\Models\Estancia|null $estancias
 * @property-read \App\Models\Paciente $pacientes
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamiliarResponsable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamiliarResponsable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamiliarResponsable query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamiliarResponsable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamiliarResponsable whereNombreCompleto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamiliarResponsable wherePacienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamiliarResponsable whereParentesco($value)
 * @mixin \Eloquent
 */
class FamiliarResponsable extends Model
{
    protected $table = 'familiar_responsables';
    public $incrementing = true;
    
    protected $fillable = [
        'parentesco',
        'nombre_completo',
        'paciente_id',
    ];

    public $timestamps = false;

    public function estancias():HasOne
    {
        return $this->hasOne(Estancia::class,'familiar_responsable_id');
    }

    public function pacientes():BelongsTo
    {
        return $this->belongsTo(Paciente::class,'paciente_id');
    }
}
