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

    // Relación con Interconsulta (una interconsulta puede tener muchos honorarios)
    public function interconsulta()
    {
        return $this->belongsTo(Interconsulta::class);
    }
}