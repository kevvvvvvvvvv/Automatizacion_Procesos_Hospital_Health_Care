<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $via_administracion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoViaAdministracion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoViaAdministracion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoViaAdministracion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoViaAdministracion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoViaAdministracion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoViaAdministracion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatalogoViaAdministracion whereViaAdministracion($value)
 * @mixin \Eloquent
 */
class CatalogoViaAdministracion extends Model
{
    protected $fillable = [
        'via_administracion'
    ];
}
