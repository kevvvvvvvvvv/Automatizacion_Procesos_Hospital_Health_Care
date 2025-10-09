<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación: Un cargo tiene muchos usuarios (doctores).
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'cargo_id');
    }
}
