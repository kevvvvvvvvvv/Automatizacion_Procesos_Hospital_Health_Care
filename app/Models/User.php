<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'users';
    protected $primaryKey = 'curpc';
    public $incrementing = false;   
    protected $keyType = 'string'; 


    protected $fillable = [
        'curpc',
        'nombre',
        'apellidop',
        'apellidom',
        'sexo',
        'fechaNacimiento',
        'id_colaborador_responsable',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'id_colaborador_responsable', 'curpc');
    }

    public function colaboradores()
    {
        return $this->hasMany(User::class, 'id_colaborador_responsable', 'curpc');
    }

    public function getNameAttribute()
    {
        return trim("{$this->nombre} {$this->apellidop} {$this->apellidom}");
    }

}

