<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'curp',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'fecha_nacimiento',
        'colaborador_responsable_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 3. RELACIONES ACTUALIZADAS PARA USAR LOS IDs NUMÉRICOS
    public function responsable()
    {
        return $this->belongsTo(User::class, 'colaborador_responsable_id');
    }

    public function colaboradores()
    {
        return $this->hasMany(User::class, 'colaborador_responsable_id');
    }

    // 4. ACCESSOR 'name' ACTUALIZADO CON LOS NOMBRES DE COLUMNA CORRECTOS
    public function getNameAttribute()
    {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }
}