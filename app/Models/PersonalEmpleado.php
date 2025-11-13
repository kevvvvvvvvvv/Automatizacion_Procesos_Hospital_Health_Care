<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalEmpleado extends Model
{
    protected $table = 'personal_empleados';

    protected $fillable = [
        'id',
        'nota_postoperatoria_id',
        'user_id',
        'cargo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function notaPostoperatoria(): BelongsTo
    {
        return $this->belongsTo(NotaPostoperatoria::class, 'nota_postoperatoria_id', 'id');
    }
}
