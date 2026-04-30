<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Formulario\FormularioInstancia;

/**
 * @property int $id
 * @property string $resumen_medico
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResumenMedico newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResumenMedico newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResumenMedico query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResumenMedico whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResumenMedico whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResumenMedico whereResumenMedico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResumenMedico whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ResumenMedico extends Model
{
    protected $table = "resumen_medicos";
    protected $fillable = [
        'id',
        'resumen_medico',
         
    ];
    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id','id');
    }
    
}
