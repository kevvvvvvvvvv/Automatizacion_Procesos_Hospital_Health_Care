<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Auditable;

class Estancia extends Model
{
    use HasFactory, Auditable;

    protected $table = 'estancias';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'folio',
        'fecha_ingreso',
        'fecha_egreso',
        'num_habitacion',
        'tipo_estancia',
        'modalidad_ingreso',
        'paciente_id',
        'estancia_anterior_id',
        'created_by', 
        'updated_by'
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
