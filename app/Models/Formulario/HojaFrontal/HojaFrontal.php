<?php

namespace App\Models\Formulario\HojaFrontal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Formulario\FormularioInstancia;
use App\Models\User;

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
