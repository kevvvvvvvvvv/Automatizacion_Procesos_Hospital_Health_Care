<?php

namespace App\Models;

// Imports principales para Authenticatable y traits
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; // Para API tokens (opcional, remueve si no usas Sanctum)

// Import para fechas (opcional)
use Carbon\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable // Ahora debería reconocer Authenticatable
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
        'name',
        'email',
        'password',
        'curp',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'fecha_nacimiento', // Para permitir crear/actualizar desde forms
        'cargo_id', // Si usas cargos
        'colaborador_responsable_id',
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
        'fecha_nacimiento' => 'date', // Convierte a Carbon\Carbon automáticamente
    ];

    // Relaciones
    public function cargo() 
    { 
        return $this->belongsTo(Cargo::class); 
    }
    
    public function colaborador_responsable() 
    { 
        return $this->belongsTo(User::class, 'colaborador_responsable_id'); 
    }

    // Opcional: Relación inversa (usuarios que yo superviso)
    public function doctores_supervisados()
    {
        return $this->hasMany(User::class, 'colaborador_responsable_id');
    }

    // Accessor para nombre completo (usado en index() y show())
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . ($this->apellido_materno ?? ''));
    }

    // Accessor para sobrescribir 'name' (para auth y vistas)
    public function getNameAttribute()
    {
        // Si tienes campo 'name' separado, úsalo; sino, usa nombre_completo
        if (isset($this->attributes['name']) && !empty($this->attributes['name'])) {
            return $this->attributes['name'];
        }
        return $this->nombre_completo;  // MEJORADO: Usa el accessor existente
    }

    // NUEVO: Accessor para fecha de nacimiento formateada (e.g., "01/01/1980")
    public function getFechaNacimientoFormateadaAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->format('d/m/Y') : 'No especificada';
    }

    // Opcional: Accessor para cargo con fallback
    public function getCargoNombreAttribute()
    {
        return $this->cargo ? $this->cargo->nombre : 'Sin cargo asignado';
    }
}
