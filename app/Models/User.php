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
use App\Models\BackupsRestauration\Backups;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Cashier\Billable;

/**
 * @property int $id
 * @property string $curp
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $sexo
 * @property \Illuminate\Support\Carbon $fecha_nacimiento
 * @property string $telefono
 * @property int|null $colaborador_responsable_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \App\Models\Cargo|null $cargo
 * @property-read User|null $colaborador_responsable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CredencialEmpleado> $credenciales
 * @property-read int|null $credenciales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CredencialEmpleado> $credencialesEmpleado
 * @property-read int|null $credenciales_empleado_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $doctores_supervisados
 * @property-read int|null $doctores_supervisados_count
 * @property-read mixed $fecha_nacimiento_formateada
 * @property-read mixed $name
 * @property-read mixed $nombre_completo
 * @property-read array $professional_qualifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User doctores()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereApellidoMaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereApellidoPaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereColaboradorResponsableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Backups> $backups
 * @property-read int|null $backups_count
 * @mixin \Eloquent
 */
class User extends Authenticatable 
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 
        'nombre', 'apellido_paterno', 'apellido_materno','telefono',
        'curp', 'sexo', 'fecha_nacimiento', 'colaborador_responsable_id',
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

    public function backups()
    {
        return $this->hasMany(Backups::class, 'user_id', 'id');
    }
}
