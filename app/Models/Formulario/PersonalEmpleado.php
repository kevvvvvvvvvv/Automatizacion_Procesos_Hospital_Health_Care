<?php

namespace App\Models\Formulario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class PersonalEmpleado extends Model
{
    protected $table = 'personal_empleados';

    protected $fillable = [
        'id',
        'nota_postoperatoria_id',
        'user_id',
        'cargo',
        'itemable_id',
        'itemable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
