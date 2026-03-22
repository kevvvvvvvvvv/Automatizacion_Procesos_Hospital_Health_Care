<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caja extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'activa',
    ];

    public function sesionesCaja(): HasMany
    {
        return $this->hasMany(SesionCaja::class);
    }
}
