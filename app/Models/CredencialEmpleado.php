<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CredencialEmpleado extends Model
{
    use HasFactory;

    protected $table = 'credencial_empleados'; // Especifica explícitamente (Laravel asume plural)

          protected $fillable = [
            'user_id',
            'titulo',
            'cedula_profesional',
            'cedula',  // Si lo usas
        ];
     

    // Relación inversa (opcional)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); // Coincide con el foreign key
    }
}
