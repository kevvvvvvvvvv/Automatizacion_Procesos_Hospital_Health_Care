<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $medico_id
 * @property string|null $notas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @property-read \App\Models\User $medico
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

    public function medico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medico_id','id');
    }
}
