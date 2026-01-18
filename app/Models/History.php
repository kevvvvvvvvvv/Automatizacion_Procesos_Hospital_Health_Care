<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id El usuario que realizó la acción
 * @property string $model_type El modelo que fue afectado (ej: App\Models\Product)
 * @property int $model_id El ID del registro afectado
 * @property string $action La acción realizada (created, updated, deleted)
 * @property array<array-key, mixed>|null $before Estado del modelo antes del cambio
 * @property array<array-key, mixed>|null $after Estado del modelo después del cambio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $model
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereUserId($value)
 * @mixin \Eloquent
 */
class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'action',
        'before',
        'after',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'before' => 'array',
        'after'  => 'array', 
    ];


    public function model()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}