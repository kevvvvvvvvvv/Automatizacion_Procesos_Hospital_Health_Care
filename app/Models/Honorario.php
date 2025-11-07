<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Honorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'interconsulta_id',
        'monto',
        'descripcion',
    ];

    protected $casts = [
        'monto' => 'decimal:2',  // Para manejar decimales correctamente
    ];

    // Relación con Interconsulta
    public function interconsulta()
    {
        return $this->belongsTo(Interconsulta::class);
    }
}