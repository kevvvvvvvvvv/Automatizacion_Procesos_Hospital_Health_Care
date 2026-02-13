<?php

namespace App\Models\BackupsRestauration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

/**
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $path
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backups whereUserId($value)
 * @mixin \Eloquent
 */
class Backups extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'path',
        'status',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','idusuario');
    }
    
}
