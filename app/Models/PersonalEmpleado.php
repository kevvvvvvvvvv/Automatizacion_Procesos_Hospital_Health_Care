<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $itemable_type
 * @property int $itemable_id
 * @property int $user_id
 * @property string $cargo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $itemable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado whereCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado whereItemableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado whereItemableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalEmpleado whereUserId($value)
 * @mixin \Eloquent
 */
class PersonalEmpleado extends Model
{
    protected $table = 'personal_empleados';

    protected $fillable = [
        'id',
        'nota_postoperatoria_id',
        'user_id',
        'cargo',
        'itemable_id',
        'itemable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
