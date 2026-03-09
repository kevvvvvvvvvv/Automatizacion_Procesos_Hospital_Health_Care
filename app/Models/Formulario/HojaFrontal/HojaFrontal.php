<?php

namespace App\Models\Formulario\HojaFrontal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Formulario\FormularioInstancia;
use App\Models\User;

/**
 * @property int $id
 * @property int $medico_id
 * @property string|null $notas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read FormularioInstancia $formularioInstancia
 * @property-read User $medico
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal whereMedicoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal whereNotas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaFrontal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaFrontal extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'hoja_frontales';

    /**
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 
        'medico_id',
        'notas'
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

   // En App\Models\Formulario\HojaFrontal\HojaFrontal.php
public function medico()
{
    // Asumiendo que hoja_frontales tiene una columna medico_id o user_id
    return $this->belongsTo(\App\Models\User::class, 'medico_id'); 
}
}
