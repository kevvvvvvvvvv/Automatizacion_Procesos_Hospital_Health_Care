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

// IMPORTS AGREGADOS PARA LA RELACIÓN (CRÍTICOS PARA EL ERROR)
use Illuminate\Database\Eloquent\Relations\HasMany; // Para el return type : HasMany en credenciales()
use App\Models\CredencialEmpleado; // Para hasMany(CredencialEmpleado::class) sin FQCN

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
        'name', 'email', 'password', // Estándar
        'nombre', 'apellido_paterno', 'apellido_materno', // De doctor
        'curp', 'sexo', 'fecha_nacimiento', 'cargo_id', 'colaborador_responsable_id',
        // NO incluyas 'professional_qualifications' - se maneja vía relación y accesor
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
        // REMOVIDO: 'professional_qualifications' => 'array' - No es un campo directo; usa el accesor
    ];

    // Relaciones (sin cambios)
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

    // Accessor para nombre completo (sin cambios – ya está perfecto)
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . ($this->apellido_materno ?? ''));
    }

    // Accessor para sobrescribir 'name' (sin cambios)
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

    // Opcional: Accessor para cargo con fallback (sin cambios)
    public function getCargoNombreAttribute()
    {
        return $this->cargo ? $this->cargo->nombre : 'Sin cargo asignado';
    }

    // AGREGADO: Scope para doctores (opcional, útil en queries)
    public function scopeDoctores($query)
    {
        return $query->whereNotNull('cargo_id');  // Solo usuarios con cargo (doctores)
    }

    // RELACIÓN CORREGIDA: Ahora con import correcto, el return type funciona
      public function credenciales(): HasMany
  {
      return $this->hasMany(CredencialEmpleado::class, 'user_id'); // Cambia 'id_user' por 'user_id'
  }

    // Accessor para professional_qualifications (sin cambios – funciona con la relación)
    public function getProfessionalQualificationsAttribute(): array
    {
        return $this->credenciales->map(function ($credencial) {
            return [
                'titulo' => $credencial->titulo,
                'cedula' => $credencial->cedula ?? '', // String vacío si null
            ];
        })->toArray();
    }
}
