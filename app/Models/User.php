<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; 
use Carbon\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use App\Models\CredencialEmpleado;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable 
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    // Traits opcionales: Descomenta si los usas
    // use TwoFactorAuthenticatable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 
        'nombre', 'apellido_paterno', 'apellido_materno', 
        'curp', 'sexo', 'fecha_nacimiento', 'cargo_id', 'colaborador_responsable_id',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'fecha_nacimiento' => 'date',
    ];

    public function cargo() 
    { 
        return $this->belongsTo(Cargo::class); 
    }
    
    public function colaborador_responsable() 
    { 
        return $this->belongsTo(User::class, 'colaborador_responsable_id'); 
    }

    public function doctores_supervisados()
    {
        return $this->hasMany(User::class, 'colaborador_responsable_id');
    }

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . ($this->apellido_materno ?? ''));
    }


    public function getNameAttribute()
    {
        if (isset($this->attributes['name']) && !empty($this->attributes['name'])) {
            return $this->attributes['name'];
        }
        return $this->nombre_completo;  
    }

    public function getFechaNacimientoFormateadaAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->format('d/m/Y') : 'No especificada';
    }


    public function getCargoNombreAttribute()
    {
        return $this->cargo ? $this->cargo->nombre : 'Sin cargo asignado';
    }


    public function scopeDoctores($query)
    {
        return $query->whereNotNull('cargo_id');  
    }


      public function credenciales(): HasMany
    {
        return $this->hasMany(CredencialEmpleado::class, 'user_id'); 
    }

    public function getProfessionalQualificationsAttribute(): array
    {
        return $this->credenciales->map(function ($credencial) {
            return [
                'titulo' => $credencial->titulo,
                'cedula_profesional' => $credencial->cedula ?? '', 
            ];
        })->toArray();
    }

    public function credencialesEmpleado(): HasMany
    {
        return $this->hasMany(CredencialEmpleado::class);
    }
}
