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
        'id_user', // Coincide con la relación en User
        'titulo',
        'cedula',
    ];

    // Relación inversa (opcional)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user'); // Coincide con el foreign key
    }
}
