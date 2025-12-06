<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
