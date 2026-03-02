<?php

namespace App\Models\Formulario\Interconsulta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Honorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'interconsulta_id',
        'monto',
        'descripcion',
    ];

    protected $casts = [
        'monto' => 'decimal:2', 
    ];

    // Relación con Interconsulta
    public function interconsulta()
    {
        return $this->belongsTo(Interconsulta::class);
    }
}
