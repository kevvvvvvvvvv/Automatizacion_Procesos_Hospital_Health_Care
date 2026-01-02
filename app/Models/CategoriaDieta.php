<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaDieta extends Model
{
    protected $fillable = [
        'categoria'
    ];

    public function dietas(): HasMany
    {
        return $this->hasMany(Dieta::class);
    }
}
