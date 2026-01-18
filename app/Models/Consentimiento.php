<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $estancia_id
 * @property string|null $diagnostico
 * @property int|null $user_id
 * @property string|null $route_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Estancia|null $estancia
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento whereDiagnostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento whereEstanciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento whereRoutePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consentimiento whereUserId($value)
 * @mixin \Eloquent
 */
class Consentimiento extends Model
{
    protected $fillable = [
        'id',
        'fecha',
        'estancia_id',
        'diagnostico',
        'user_id',
        'route_pdf',
    ];
    
    
    public function estancia():BelongsTo
    {
        return $this->belongsTo(Estancia::class,'estancia_id','id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
