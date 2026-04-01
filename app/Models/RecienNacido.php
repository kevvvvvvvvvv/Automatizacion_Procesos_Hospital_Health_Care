<?php

namespace App\Models;

use App\Models\Formulario\FormularioInstancia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecienNacido extends Model
{
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'area',
        'nombre_rn',
        'sexo',
        'fecha_rn',
        'hora_rn',
        'peso',
        'talla',
        'habitus_exterior',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'habitus_exterior' => 'array',
        'fecha_rn' => 'date',
    ];


    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id');
    }
}