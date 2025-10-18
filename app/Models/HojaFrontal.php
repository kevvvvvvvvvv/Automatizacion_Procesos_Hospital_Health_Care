<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
