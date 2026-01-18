<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $categoria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dieta> $dietas
 * @property-read int|null $dietas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaDieta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaDieta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaDieta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaDieta whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaDieta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaDieta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaDieta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CategoriaDieta extends Model
{
    protected $fillable = [
        'categoria'
    ];

    public function dietas(): HasMany
    {
        return $this->hasMany(Dieta::class);
    }
}
