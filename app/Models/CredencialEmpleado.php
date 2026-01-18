<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $titulo
 * @property string $cedula_profesional
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado whereCedulaProfesional($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CredencialEmpleado whereUserId($value)
 * @mixin \Eloquent
 */
class CredencialEmpleado extends Model
{
    use HasFactory;

    protected $table = 'credencial_empleados'; 
          protected $fillable = [
            'user_id',
            'titulo',
            'cedula_profesional',
            'cedula',  
        ];
     

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
