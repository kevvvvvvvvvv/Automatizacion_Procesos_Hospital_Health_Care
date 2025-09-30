<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estancia extends Model
{
    use HasFactory;

    protected $table = 'estancias';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'fecha_ingreso',
        'fecha_egreso',
        'num_habitacion',
        'tipo_estancia',
        'paciente_id',
        'estancia_anterior_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'id');
    }

    public function estanciaAnterior(): BelongsTo
    {
        return $this->belongsTo(Estancia::class, 'estancia_anterior_id');
    }

    public function reingresos(): HasMany
    {
        return $this->hasMany(Estancia::class, 'estancia_anterior_id');
    }
}
